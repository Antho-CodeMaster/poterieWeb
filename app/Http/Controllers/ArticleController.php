<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Artiste;
use App\Models\Mot_cle;
use App\Models\Mot_cle_article;
use App\Models\Photo_article;
use App\Models\Signalement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Stripe\Climate\Order;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('query');
        $etat = $request->input('etat');
        $sensible = $request->input('sensible');
        $vedette = $request->input('vedette');
        $page = $request->input('page', 1);

        $articles = Article::where('id_etat', '!=', 3)
            ->when(isset($etat) && $etat != "tous", function ($query) use ($etat) {
                if ($etat == "Public")
                    $query->where('id_etat', 1);
                else if ($etat == "Masqué")
                    $query->where('id_etat', 2);
            })
            ->when(isset($searchTerm), function ($query) use ($searchTerm) {
                $query->where(function ($subQuery) use ($searchTerm) {
                    $subQuery->where('nom', 'LIKE', '%' . $searchTerm . '%') //Nom de l'article correspond
                        ->orWhereHas('artiste', function ($subsubQuery) use ($searchTerm) {
                            $subsubQuery->where('nom_artiste', 'LIKE', '%' . $searchTerm . '%') //Nom de l'artiste correspond
                                ->orWhereHas('user', function ($subsubsubQuery) use ($searchTerm) {
                                    $subsubsubQuery->where('name', 'LIKE', '%' . $searchTerm . '%'); //Nom de l'user si l'artiste n'a pas de nom
                                });
                        });
                });
            })
            ->when($sensible === "true", function ($query){
                    $query->where('is_sensible', 1);
            })
            ->when($vedette === "true", function ($query){
                    $query->where('is_en_vedette', 1);
            })
            ->whereHas('artiste', function ($query) {
                $query->where('actif', true); //L'artiste doit être actif présentement
            })
            ->orderBy('date_publication', 'desc');

        $count = $articles->count();
        $articles = $articles->skip(50 * ($page - 1))
            ->take(50)
            ->get();


        return view('admin/articles', [
            'articles' => $articles,
            'query' => $request->input('query'),
            'etat' => $request->input('etat'),
            'sensible' => $request->input('sensible'),
            'vedette' => $request->input('vedette'),
            'page' => $page - 1,
            'count' => $count,
            'total_pages' => ceil($count / 50),
        ]);
    }

    /* Form pour l'ajout d'un article */
    public function create()
    {
        $artiste = Artiste::where('id_user', Auth::user()->id)->first();

        return view("articleSettings.addArticle-form", [
            'artiste' => $artiste
        ]);
    }

    /* Form pour la modification d'un article */
    public function showModifArticle($idArticle)
    {
        $article = Article::with("motCles")->where("id_article", $idArticle)->first();
        $artiste = Artiste::where('id_user', Auth::user()->id)->first();
        $photoPath[] = $article->photosArticle->path;

        return view("articleSettings.modifArticle-form", [
            'article' => $article,
            'artiste' => $artiste,
            "photoPath" => $photoPath
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->routeIs('addArticle')) {
            /* 1. Vérifie si l'artiste est actif ou non */
            $artiste = Artiste::with("reseaux", "articles")->where('id_artiste', $request->input("idArtiste"))->first();
            if ($artiste->actif == 0) {
                if (Auth::id() != $artiste->id_user) {
                    session()->flash('errorInactif', 'cette artiste n\'existe pas.');
                    return redirect()->back();
                }

                session()->flash('errorInactif', 'Vous n\'est plus un artiste. Veuillez effectuer une nouvelle demande si vous voulez avoir accès à votre kiosque à nouveau.');
                return redirect()->back();
            }

            /* 2. Valiation des entrées */
            $validatedData = $request->validate([
                "idArtiste" => "required",
                "masquer" => "required|",
                "enVedette" => "required|in:0,1",
                "flouter" => "required|in:0,1",
                "prixArticle" => "required",
                "nomArticle" => "required|max:128",
                "pieceUnique" => "required|in:0,1",
                "descriptionArticle" => "required|max:255",
                "hauteurArticle" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01",
                "largeurArticle" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01",
                "profondeurArticle" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01",
                "poidsArticle" => "nullable|regex:/^\d+(\.\d{1,2})?$/",
                "typePiece" => "required|in:0,1",
                "quantiteArticle" => "required|integer|min:1",
                "motClesArticle" => "nullable|regex:/^#[a-zA-ZÀ-ÿ0-9]+(#[a-zA-ZÀ-ÿ0-9]+)*$/",
                "photo1" => "required|mimes:jpeg,png,jpg",
                "photo2" => "mimes:jpeg,png,jpg",
                "photo3" => "mimes:jpeg,png,jpg",
                "photo4" => "mimes:jpeg,png,jpg",
                "photo5" => "mimes:jpeg,png,jpg",
            ], [
                "nomArticle.required" => "Le nom de l'article est obligatoire.",
                "nomArticle.max" => "Le nom de l'article ne peut pas dépasser 128 caractères.",

                "pieceUnique.required" => "Le champ pièce unique est obligatoire.",
                "pieceUnique.in" => "La valeur du champ pièce unique doit être soit 'Unique' soit 'En série'.",

                "descriptionArticle.required" => "La description de l'article est obligatoire.",
                "descriptionArticle.max" => "La description de l'article ne peut pas dépasser 255 caractères.",

                "hauteurArticle.required" => "La hauteur de l'article est obligatoire.",
                "hauteurArticle.numeric" => "La hauteur de l'article doit être un nombre.",
                "hauteurArticle.regex" => "La hauteur de l'article doit être un nombre valide avec au maximum deux décimales.",
                "hauteurArticle.min" => "La hauteur de l'article doit être supérieure à 0.01.",

                "largeurArticle.required" => "La largeur de l'article est obligatoire.",
                "largeurArticle.numeric" => "La largeur de l'article doit être un nombre.",
                "largeurArticle.regex" => "La largeur de l'article doit être un nombre valide avec au maximum deux décimales.",
                "largeurArticle.min" => "La largeur de l'article doit être supérieure ou égale à 0.01.",

                "profondeurArticle.required" => "La profondeur de l'article est obligatoire.",
                "profondeurArticle.numeric" => "La profondeur de l'article doit être un nombre.",
                "profondeurArticle.regex" => "La profondeur de l'article doit être un nombre valide avec au maximum deux décimales.",
                "profondeurArticle.min" => "La profondeur de l'article doit être supérieure ou égale à 0.01.",

                "poidsArticle.regex" => "Le poids de l'article doit être un nombre valide avec au maximum deux décimales.",
                "poidsArticle.min" => "Le poids de l'article doit être supérieur ou égal à 0.01.",

                "typePiece.required" => "Le type de pièce est obligatoire.",
                "typePiece.in" => "La valeur du type de pièce doit être soit 'Non alimentaire' soit 'Alimentaire'.",

                "quantiteArticle.required" => "La quantité de l'article est obligatoire.",
                "quantiteArticle.integer" => "La quantité de l'article doit être un nombre entier.",
                "quantiteArticle.min" => "La quantité de l'article doit être au moins 1.",

                "motClesArticle.regex" => "Les mots clés de l'article doivent commencer par '#' et ne contenir aucun espacement.",

                'photo1.mimes' => 'La photo 1 doit être au format JPEG, PNG ou JPG.',
                'photo1.required' => 'Il doit y avoir au moins 1 photo afin d\'ajouter un nouvel article',
                'photo2.mimes' => 'La photo 2 doit être au format JPEG, PNG ou JPG.',
                'photo3.mimes' => 'La photo 3 doit être au format JPEG, PNG ou JPG.',
                'photo4.mimes' => 'La photo 4 doit être au format JPEG, PNG ou JPG.',
                'photo5.mimes' => 'La photo 5 doit être au format JPEG, PNG ou JPG.',
            ]);

            /* 3. Stock des cm même si l'entré c'est des pouces */
            if ($artiste->units == 1) {
                $validatedData['hauteurArticle'] = $validatedData['hauteurArticle'] * 2.54;
                $validatedData['largeurArticle'] = $validatedData['largeurArticle'] * 2.54;
                $validatedData['profondeurArticle'] = $validatedData['profondeurArticle'] * 2.54;
            }

            /* 4. Création de l'article */
            $newArticle = Article::create([
                'id_artiste' => $validatedData['idArtiste'],
                'id_etat' => $validatedData['masquer'],
                'nom' => $validatedData['nomArticle'],
                'description' => $validatedData['descriptionArticle'],
                'prix' => $validatedData['prixArticle'],
                'hauteur' => $validatedData['hauteurArticle'],
                'largeur' => $validatedData['largeurArticle'],
                'profondeur' => $validatedData['profondeurArticle'],
                'poids' => $validatedData['poidsArticle'],
                'quantite_disponible' => $validatedData['quantiteArticle'],
                'date_publication' => now(), // Utiliser now() pour obtenir la date actuelle
                'is_en_vedette' => $validatedData['enVedette'],
                'is_sensible' => $validatedData['flouter'],
                'is_alimentaire' => $validatedData['typePiece'],
                'is_unique' => $validatedData['pieceUnique'],
                'couleur' => 'brun marde', // Vous pouvez le modifier selon vos besoins
            ]);

            /* 5. Stockage en BD du nouvelle article */
            if ($newArticle->save()) {

                /* 6. Gestion des mots clés*/
                $motsClesString = $validatedData['motClesArticle'];

                $motsClesArray = array_filter(array_map('trim', explode('#', $motsClesString)));

                foreach ($motsClesArray as $motCle) {
                    /* Vérifie si le mot clé existe dans la table "Mot_Cle", si non il le crée et si oui, il y accède */
                    $instanceMotCle = Mot_cle::where("mot_cle", $motCle)->firstOrCreate(["mot_cle" => $motCle]);
                    if ($instanceMotCle == null) {
                        session()->flash('erreurMotsCles', 'Un problème lors de l\'ajout des mots clés s\'est produit, veuillez réessayer.');

                        /* Retour à la vue */
                        $idUser = Auth::user()->id;
                        return redirect()->route('addArticleForm', ['idUser' => $idUser]);
                    }
                    /* Vérifie si le mot clé existe dans la table "Mot_Cle_article", si non il le crée et si oui, il y accède */
                    Mot_cle_article::where("id_mot_cle", $instanceMotCle->id_mot_cle)
                        ->where("id_article", $newArticle->id_article)
                        ->firstOrCreate([
                            "id_mot_cle" => $instanceMotCle->id_mot_cle,
                            "id_article" => $newArticle->id_article
                        ]);
                }

                /* 7. Gestion des photos */
                for ($i = 1; $i <= 5; $i++) {
                    if ($request->hasFile('photo' . $i)) {
                        $file = $request->file('photo' . $i);

                        // Créer un nom de fichier unique avec un identifiant aléatoire
                        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                        // Stocker le fichier dans le répertoire public
                        $filePath = $file->storeAs('tests', $filename, 'public');

                        // Déplacer le fichier vers le dossier public (optionnel, dépendant de votre configuration)
                        $file->move(public_path('img/tests'), $filename);

                        $newPhotoArticle = new Photo_article();
                        $newPhotoArticle->id_article = $newArticle->id_article;
                        $newPhotoArticle->path = $filePath; // Stockage du chemin exact en base de données

                        if (!$newPhotoArticle->save()) {
                            session()->flash('erreurPhotos', 'Un problème lors de l\'ajout des photos s\'est produit, veuillez réessayer.');

                            /* Retour à la vue */
                            $idUser = Auth::user()->id;
                            return redirect()->route('addArticleForm', ['idUser' => $idUser]);
                        }
                    }
                }

                session()->flash('succesArticle', 'L\'article a bien été ajouté');
            } else {
                session()->flash('erreurArticle', 'Un problème lors de l\'ajout de l\'article s\'est produit');
            }

            /* Retour à la vue */
            $idUser = Auth::user()->id;
            return redirect()->route('addArticleForm', ['idUser' => $idUser]);
        } elseif ($request->routeIs('signaleArticle')) { /* Fonction pour ajouter un signalement */
            /* Validation des entrées */
            $validatedData = $request->validate([
                "idArticle" => "required",
                "signaleDescription" => "required|max:255",
            ], [
                "signaleDescription.required" => "La description du signalement est obligatoire.",
                "signaleDescription.max" => "La description du signalement ne peut pas dépasser 255 caractères.",
            ]);

            $newsignalement = Signalement::create([
                "id_user" => Auth::user()->id,
                "id_article" => $validatedData["idArticle"],
                "date" => now(),
                "description" => $validatedData["signaleDescription"]
            ]);

            /* Stockage en BD du nouvel article */
            if ($newsignalement->save()) {
                session()->flash('succesSignalement', 'Le signalement a été envoyé');
            } else {
                session()->flash('echecSignalement', 'Un problème lors du signalement de l\'article s\'est produit.');
            }

            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(article $article)
    {
        $idUser = Auth::user()->id;
        $artiste = Artiste::with("reseaux", "articles")->where('id_user', $idUser)->first();

        $articles = $artiste->articles()
            ->orderBy('created_at', 'desc')  // Tri par date décroissante
            ->get();

        return view('articleSettings/tousMesArticles', [
            'artiste' => $artiste,
            'articles' => $articles,
        ]);
    }

    /**
     * Display the searched articles.
     */
    public function getSearch(Request $request)
    {
        // Retrieve the search term from the request
        $searchTerm = $request->input('query');

        // Query the articles table to find partial matches in the 'nom' and 'description' fields
        $articles = Article::where(function ($query) use ($searchTerm) {
            $query->where('nom', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                ->orWhereHas('motCles', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('mot_cle', 'LIKE', '%' . $searchTerm . '%');
                });
        })
            ->where('id_etat', 1)
            ->get();

        $artistes = Artiste::where(function ($query) use ($searchTerm) {
                $query->where('nom_artiste', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhereHas('user', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'LIKE', '%' . $searchTerm . '%');
                    });
            })
                ->where('actif', 1)
                ->get();

        // Return the results to the view with the search term and matched articles
        return view('recherche.recherche', compact('articles', 'searchTerm', 'artistes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, article $article)
    {
        if ($request->routeIs('deleteArticle')) {

            /* 1. Récupérer l'article en BD */
            $idArticle = $request->input("idArticle");
            $article = Article::where("id_article", $idArticle)->first();

            /* 2. Changer l'état (masqué aux clients et à l'artiste) */
            $article->id_etat = 3;

            /* 3. Mettre à jours l'article en BD */
            if ($article->save()) {
                session()->flash('succesDeleteArticle', 'L\'article a bien été supprimé');
            } else {
                session()->flash('erreurDeleteArticle', 'Un problème lors de la suppression de l\'article s\'est produit');
            }

            /* Retour à la vue */
            $idUser = $request->input("idUser");
            return redirect()->route('kiosque', ['idUser' => $idUser]);
        } elseif ($request->routeIs('modifArticle')) {

            /* 1. Vérifie si l'artiste est actif ou non */
            $artiste = Artiste::with("reseaux", "articles")->where('id_artiste', $request->input("idArtiste"))->first();
            if ($artiste->actif == 0) {
                if (Auth::id() != $artiste->id_user) {
                    session()->flash('errorInactif', 'L\'utilisateur n\'est plus artiste.');
                    return redirect()->back();
                }

                session()->flash('errorInactif', 'Vous n\'est plus un artiste. Veuillez effectuer une nouvelle demande si vous voulez avoir accès à votre kiosque à nouveau.');
                return redirect()->back();
            }

            /* 2. Validation des entrés */
            $validatedData = $request->validate([
                "idArtiste" => "required",
                "masquer" => "required|",
                "enVedette" => "required|in:0,1",
                "flouter" => "required|in:0,1",
                "prixArticle" => "required",
                "nomArticle" => "required|max:128",
                "pieceUnique" => "required|in:0,1",
                "descriptionArticle" => "required|max:255",
                "hauteurArticle" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01",
                "largeurArticle" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01",
                "profondeurArticle" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01",
                "poidsArticle" => "nullable|regex:/^\d+(\.\d{1,2})?$/",
                "typePiece" => "required|in:0,1",
                "quantiteArticle" => "required|integer|min:1",
                "motClesArticle" => "nullable|regex:/^#[a-zA-ZÀ-ÿ0-9]+(#[a-zA-ZÀ-ÿ0-9]+)*$/",
                "photo1" => "mimes:jpeg,png,jpg",
                "photo2" => "mimes:jpeg,png,jpg",
                "photo3" => "mimes:jpeg,png,jpg",
                "photo4" => "mimes:jpeg,png,jpg",
                "photo5" => "mimes:jpeg,png,jpg",
            ], [
                "nomArticle.required" => "Le nom de l'article est obligatoire.",
                "nomArticle.max" => "Le nom de l'article ne peut pas dépasser 128 caractères.",

                "pieceUnique.required" => "Le champ pièce unique est obligatoire.",
                "pieceUnique.in" => "La valeur du champ pièce unique doit être soit 'Unique' soit 'En série'.",

                "descriptionArticle.required" => "La description de l'article est obligatoire.",
                "descriptionArticle.max" => "La description de l'article ne peut pas dépasser 255 caractères.",

                "hauteurArticle.required" => "La hauteur de l'article est obligatoire.",
                "hauteurArticle.numeric" => "La hauteur de l'article doit être un nombre.",
                "hauteurArticle.regex" => "La hauteur de l'article doit être un nombre valide avec au maximum deux décimales.",
                "hauteurArticle.min" => "La hauteur de l'article doit être supérieure à 0.01.",

                "largeurArticle.required" => "La largeur de l'article est obligatoire.",
                "largeurArticle.numeric" => "La largeur de l'article doit être un nombre.",
                "largeurArticle.regex" => "La largeur de l'article doit être un nombre valide avec au maximum deux décimales.",
                "largeurArticle.min" => "La largeur de l'article doit être supérieure ou égale à 0.01.",

                "profondeurArticle.required" => "La profondeur de l'article est obligatoire.",
                "profondeurArticle.numeric" => "La profondeur de l'article doit être un nombre.",
                "profondeurArticle.regex" => "La profondeur de l'article doit être un nombre valide avec au maximum deux décimales.",
                "profondeurArticle.min" => "La profondeur de l'article doit être supérieure ou égale à 0.01.",

                "poidsArticle.regex" => "Le poids de l'article doit être un nombre valide avec au maximum deux décimales.",

                "typePiece.required" => "Le type de pièce est obligatoire.",
                "typePiece.in" => "La valeur du type de pièce doit être soit 'Non-alimentaire' soit 'Alimentaire'.",

                "quantiteArticle.required" => "La quantité de l'article est obligatoire.",
                "quantiteArticle.integer" => "La quantité de l'article doit être un nombre entier.",
                "quantiteArticle.min" => "La quantité de l'article doit être au moins 1.",

                "motClesArticle.regex" => "Les mots clés de l'article doivent commencer par '#' et contenir aucun espacement.",

                'photo1.mimes' => 'La photo 1 doit être au format JPEG, PNG ou JPG.',
                'photo2.mimes' => 'La photo 2 doit être au format JPEG, PNG ou JPG.',
                'photo3.mimes' => 'La photo 3 doit être au format JPEG, PNG ou JPG.',
                'photo4.mimes' => 'La photo 4 doit être au format JPEG, PNG ou JPG.',
                'photo5.mimes' => 'La photo 5 doit être au format JPEG, PNG ou JPG.',
            ]);

            /* 3. Stock des cm même si l'entré c'est des pouces */
            if ($artiste->units == 1) {
                $validatedData['hauteurArticle'] = $validatedData['hauteurArticle'] * 2.54;
                $validatedData['largeurArticle'] = $validatedData['largeurArticle'] * 2.54;
                $validatedData['profondeurArticle'] = $validatedData['profondeurArticle'] * 2.54;
            }

            /* 4. Chercher l'article à modifier */
            $article = Article::where('id_article', $request->input("idArticle"))->first();

            /* 5. Update de l'article*/
            if ($article->update([
                'id_etat' => $validatedData['masquer'],
                'nom' => $validatedData['nomArticle'],
                'description' => $validatedData['descriptionArticle'],
                'prix' => $validatedData['prixArticle'],
                'hauteur' => $validatedData['hauteurArticle'],
                'largeur' => $validatedData['largeurArticle'],
                'profondeur' => $validatedData['profondeurArticle'],
                'poids' => $validatedData['poidsArticle'],
                'quantite_disponible' => $validatedData['quantiteArticle'],
                'is_en_vedette' => $validatedData['enVedette'],
                'is_sensible' => $validatedData['flouter'],
                'is_alimentaire' => $validatedData['typePiece'],
                'is_unique' => $validatedData['pieceUnique'],
                'couleur' => 'brun marde', // Vous pouvez le modifier selon vos besoins
            ])) {
                session()->flash('succesArticle', 'L\'article a bien été modifié');
            } else {
                session()->flash('erreurArticle', 'Un problème lors de la modification de l\'article s\'est produit');

                /* Retour à la vue */
                return redirect()->route('modifArticleForm', ['idArticle' => $article->id_article]);
            }

            /* 6. Gestion des mots clés*/
            # On supprime tous les anciennes liaisons pour en refaire des nouveaux meme si ce sont les mêmes.
            $article->motCles()->detach();

            $motsClesString = $validatedData['motClesArticle'];

            $motsClesArray = array_filter(array_map('trim', explode('#', $motsClesString)));
            foreach ($motsClesArray as $motCle) {
                /* Vérifie si le mot clé existe dans la table "Mot_Cle", si non il le crée et si oui, il y accède */
                $instanceMotCle = Mot_cle::where("mot_cle", $motCle)->firstOrCreate(["mot_cle" => $motCle]);
                if ($instanceMotCle == null) {
                    session()->flash('erreurMotsCles', 'Un problème lors de l\'ajout des mots clés s\'est produit, veuillez réessayer');
                    /* Retour à la vue */
                    return redirect()->route('modifArticleForm', ['idArticle' => $article->id_article]);
                }
                /* Cherche le mot clé dans la table de jonction et l'update */
                Mot_cle_article::where("id_mot_cle", $instanceMotCle->id_mot_cle)
                    ->where("id_article", $article->id_article)
                    ->firstOrCreate([
                        "id_mot_cle" => $instanceMotCle->id_mot_cle,
                        "id_article" => $article->id_article
                    ]);
            }

            // 7. Gestion du téléchargement de l'image
            for ($i = 1; $i <= 5; $i++) {
                if ($request->hasFile('photo' . $i)) {
                    $file = $request->file('photo' . $i);
                    $originalFilename = $file->getClientOriginalName(); // Récupérer le nom original
                    $filePath = 'tests/' . $originalFilename; // C'est le chemin de la photo récupérer

                    // Vérifiez si le chemin de la photo existe déjà dans la base de données
                    $existingPhoto = Photo_article::where('path', $filePath)->first();

                    // Vérifiez également si le fichier existe déjà dans le stockage
                    $fileExistsInStorage = Storage::disk('public')->exists($filePath);

                    if (!$existingPhoto && !$fileExistsInStorage) { //La photo n'existe pas dans la BD ni dans le stockage
                        // La photo n'existe pas encore, téléchargez-la
                        $filename = time() . Str::random(12) . '.' . $file->getClientOriginalExtension(); // Générer un nom de fichier unique pour eviter le conflit de nom similaire
                        $file->storeAs('tests', $filename, 'public'); // Stocker dans le dossier 'tests' du disque public
                        $file->move(public_path('img/tests'), $filename);

                        // Vérifiez si c'est une photo à remplacer
                        $photoId = $request->input('photoId' . $i); // Supposons que vous ayez des IDs de photos dans votre formulaire pour la suppression

                        if ($photoId) {
                            // Récupérer l'instance de la photo à remplacer
                            $photoToUpdate = Photo_article::find($photoId);

                            if ($photoToUpdate) {
                                // Mettre à jour le chemin de la photo
                                $photoToUpdate->path = "tests/" . $filename;

                                // Enregistrer les changements
                                if (!$photoToUpdate->save()) {
                                    session()->flash('erreurPhotos', 'Un problème lors de la mise à jour des photos s\'est produit, veuillez réessayer');
                                    #return back();
                                }
                            }
                        } else {
                            // Si aucune ID n'est fournie, c'est une nouvelle photo
                            $newPhotoArticle = new Photo_article();
                            $newPhotoArticle->id_article = $article->id_article;
                            $newPhotoArticle->path = "tests/" . $filename;

                            // Stockage en BD de la nouvelle photo
                            if (!$newPhotoArticle->save()) {
                                session()->flash('erreurPhotos', 'Un problème lors de l\'ajout des photos s\'est produit, veuillez réessayer');
                                /* Retour à la vue */
                                return redirect()->route('modifArticleForm', ['idArticle' => $article->id_article]);
                            }
                        }
                    } elseif ($fileExistsInStorage) #Si la photo existe dans le disque dur
                    {
                        // Vérifiez si c'est une photo à remplacer
                        $photoId = $request->input('photoId' . $i); // Supposons que vous ayez des IDs de photos dans votre formulaire pour la suppression

                        if ($photoId) {
                            // Récupérer l'instance de la photo à remplacer
                            $photoToUpdate = Photo_article::find($photoId);

                            if ($photoToUpdate) {
                                // Mettre à jour le chemin de la photo
                                $photoToUpdate->path = "tests/" . $originalFilename;

                                // Enregistrer les changements
                                if (!$photoToUpdate->save()) {
                                    session()->flash('erreurPhotos', 'Un problème lors de la mise à jour des photos s\'est produit, veuillez réessayer');
                                    /* Retour à la vue */
                                    return redirect()->route('modifArticleForm', ['idArticle' => $article->id_article]);
                                }
                            }
                        } else {
                            $filename = time() . Str::random(12) . '.' . $file->getClientOriginalExtension(); // Générer un nom de fichier unique pour eviter le conflit de nom similaire

                            // Si aucune ID n'est fournie, c'est une nouvelle photo
                            $newPhotoArticle = new Photo_article();
                            $newPhotoArticle->id_article = $article->id_article;
                            $newPhotoArticle->path = "tests/" . $filename;

                            // Stockage en BD de la nouvelle photo
                            if (!$newPhotoArticle->save()) {
                                session()->flash('erreurPhotos', 'Un problème lors de l\'ajout des photos s\'est produit, veuillez réessayer');
                                /* Retour à la vue */
                                return redirect()->route('modifArticleForm', ['idArticle' => $article->id_article]);
                            }
                        }
                    }
                } else {
                    // Vérifiez si une photo est à remplacer, même si aucune nouvelle photo n'est téléchargée
                    $photoId = $request->input('photoId' . $i); // ID de la photo à mettre à jour

                    if ($photoId) {
                        // Récupérer l'instance de la photo à remplacer
                        $photoToUpdate = Photo_article::find($photoId);

                        // Si aucune nouvelle photo n'est téléchargée mais que nous avons un ID, nous devons nous assurer que cette photo est encore là.
                        if ($photoToUpdate) {
                            // Si la photo existe toujours, on la laisse comme ça
                            // Vous pouvez décider d'ajouter une logique ici si vous souhaitez faire autre chose
                        }
                    }
                }
            }

            /* Retour à la vue */
            return redirect()->route('modifArticleForm', ['idArticle' => $article->id_article]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(article $article) {}

    /**
     * Fonction pour filtrer les articles.
     */
    public function articleFiltre(Request $request)
    {
        // 1. Récupérer les valeurs des filtres envoyés depuis le client
        $dateFiltre = $request->input('dateFilter');
        $dateFiltre = $dateFiltre ?? '1'; //Pour filtrer en ordre croissant toujours si aucun filtre

        $usageFilter = $request->input('usageFilter');
        $pieceFilter = $request->input('pieceFilter');
        $prixMinFilter = $request->input('prixMinFilter');
        $prixMaxFilter = $request->input('prixMaxFilter');
        $masqueFilter = $request->input('masqueFilter');
        $vedetteFilter = $request->input('vedetteFilter');
        $sensibleFilter = $request->input('sensibleFilter');
        $searchTerm = $request->input('searchArticle');

        // 2. Récupérer l'artiste connecté
        $artiste = Artiste::where('id_user', Auth::id())->first();

        // 3. Commencer la requête pour les articles de l'artiste
        $articles = Article::where('id_artiste', $artiste->id_artiste)
            ->where('id_etat', '!=', 3) // Exclure les articles avec id_etat = 3
            ->when(isset($dateFiltre) && $dateFiltre !== null, function ($query) use ($dateFiltre) {
                // Filtre par date de création
                if ($dateFiltre === '1') {
                    $query->orderBy('created_at', 'desc');
                } elseif ($dateFiltre === '0') {
                    $query->orderBy('created_at', 'asc');
                }
            })
            ->when(isset($usageFilter) && $usageFilter !== 'null', function ($query) use ($usageFilter) {
                // Appliquer le filtre usage si une valeur est sélectionnée (0 ou 1)
                $query->where('is_alimentaire', (int)$usageFilter);
            })
            ->when(isset($pieceFilter) && $pieceFilter !== 'null', function ($query) use ($pieceFilter) {
                // Filtre par type de pièce : 1 pour unique, 0 pour en série
                $query->where('is_unique', $pieceFilter);
            })
            ->when(isset($prixMinFilter) && $prixMinFilter !== '', function ($query) use ($prixMinFilter) {
                // Filtre pour les prix minimum si défini
                $query->where('prix', '>=', $prixMinFilter);
            })
            ->when(isset($prixMaxFilter) && $prixMaxFilter !== '', function ($query) use ($prixMaxFilter) {
                // Filtre pour les prix maximum si défini
                $query->where('prix', '<=', $prixMaxFilter);
            })
            ->when(isset($masqueFilter) && $masqueFilter !== 'null', function ($query) use ($masqueFilter) {
                // Filtre pour visibilité (masqué ou visible)
                $query->where('id_etat', (int)$masqueFilter);
            })
            ->when(isset($vedetteFilter) && $vedetteFilter !== 'null', function ($query) use ($vedetteFilter) {
                // Filtre pour "en vedette" ou "commun"
                $query->where('is_en_vedette', (int)$vedetteFilter);
            })
            ->when(isset($sensibleFilter) && $sensibleFilter !== 'null', function ($query) use ($sensibleFilter) {
                // Filtre pour sensibilité (sensible ou insensible)
                $query->where('is_sensible', (int)$sensibleFilter);
            })
            ->when(isset($searchTerm) && $searchTerm !== 'null', function ($query) use ($searchTerm) {
                $query->where('nom', 'LIKE', '%' . $searchTerm . '%');
            })
            ->get();


        $view = view('articleSettings.partials.allArticles', compact('articles'))->render();


        // Retourner les articles sous forme de JSON
        return response()->json([
            'status' => 'success',
            'html' => $view,
        ]);
    }

    /**
     * Fonction pour filtrer les articles.
     */
    public function kiosqueFiltre(Request $request)
    {
        // 1. Récupérer les valeurs des filtres envoyés depuis le client
        $dateFiltre = $request->input('dateFilter');
        $dateFiltre = $dateFiltre ?? '1'; //Pour filtrer en ordre croissant toujours si aucun filtre

        $usageFilter = $request->input('usageFilter');
        $pieceFilter = $request->input('pieceFilter');
        $prixMinFilter = $request->input('prixMinFilter');
        $prixMaxFilter = $request->input('prixMaxFilter');
        $searchTerm = $request->input('searchArticle');

        // 2. Récupérer l'artiste connecté
        $artiste = Artiste::where('id_user', $request->input("idArtiste"))->first();

        // 3. Commencer la requête pour les articles de l'artiste
        $articles = Article::where('id_artiste', $artiste->id_artiste)
            ->when(Auth::id() === $artiste->id_user, function ($query) {
                // Si l'utilisateur est l'artiste, on ne filtre pas par l'état (on exclut quand même l'état 3)
                $query->where('id_etat', '!=', 3);
            }, function ($query) {
                // on garde uniquement ceux en état '1'
                $query->where('id_etat', 1);
            })
            ->when(isset($dateFiltre) && $dateFiltre !== null, function ($query) use ($dateFiltre) {
                // Filtre par date de création
                if ($dateFiltre === '1') {
                    $query->orderBy('created_at', 'desc');
                } elseif ($dateFiltre === '0') {
                    $query->orderBy('created_at', 'asc');
                }
            })
            ->when(isset($usageFilter) && $usageFilter !== 'null', function ($query) use ($usageFilter) {
                // Appliquer le filtre usage si une valeur est sélectionnée (0 ou 1)
                $query->where('is_alimentaire', (int)$usageFilter);
            })
            ->when(isset($pieceFilter) && $pieceFilter !== 'null', function ($query) use ($pieceFilter) {
                // Filtre par type de pièce : 1 pour unique, 0 pour en série
                $query->where('is_unique', $pieceFilter);
            })
            ->when(isset($prixMinFilter) && $prixMinFilter !== '', function ($query) use ($prixMinFilter) {
                // Filtre pour les prix minimum si défini
                $query->where('prix', '>=', $prixMinFilter);
            })
            ->when(isset($prixMaxFilter) && $prixMaxFilter !== '', function ($query) use ($prixMaxFilter) {
                // Filtre pour les prix maximum si défini
                $query->where('prix', '<=', $prixMaxFilter);
            })
            ->when(isset($searchTerm) && $searchTerm !== 'null', function ($query) use ($searchTerm) {
                $query->where('nom', 'LIKE', '%' . $searchTerm . '%');
            })
            ->get();

        try {
            $view = view('kiosque.partials.tousLesArticles.allArticlesKiosque', compact('articles', 'artiste'))->render();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }

        // Retourner les articles sous forme de JSON
        return response()->json([
            'status' => 'success',
            'html' => $view,
        ]);
    }
}
