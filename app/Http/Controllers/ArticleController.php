<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Artiste;
use App\Models\Mot_cle;
use App\Models\Mot_cle_article;
use App\Models\Photo_article;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;



class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        /* Validation des entrés */
        $validatedData = $request->validate([
            "idArtiste" => "required",
            "masquer" => "required|",
            "enVedette" => "required|in:0,1",
            "flouter" => "required|in:0,1",
            "prixArticle" => "required",
            "nomArticle" => "required|max:255",
            "pieceUnique" => "required|in:0,1",
            "descriptionArticle" => "required|max:512",
            "hauteurArticle" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01",
            "largeurArticle" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01",
            "profondeurArticle" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01",
            "poidsArticle" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01",
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
            "nomArticle.max" => "Le nom de l'article ne peut pas dépasser 255 caractères.",

            "pieceUnique.required" => "Le champ pièce unique est obligatoire.",
            "pieceUnique.in" => "La valeur du champ pièce unique doit être soit 'Unique' soit 'En série'.",

            "descriptionArticle.required" => "La description de l'article est obligatoire.",
            "descriptionArticle.max" => "La description de l'article ne peut pas dépasser 512 caractères.",

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

            "poidsArticle.required" => "Le poids de l'article est obligatoire.",
            "poidsArticle.numeric" => "Le poids de l'article doit être un nombre.",
            "poidsArticle.regex" => "Le poids de l'article doit être un nombre valide avec au maximum deux décimales.",
            "poidsArticle.min" => "Le poids de l'article doit être supérieur ou égal à 0.01.",

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

        /* Création de l'article */
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

        /* Stockage en BD du nouvelle article */
        if ($newArticle->save()) {
            session()->flash('succesArticle', 'L\'article à bien été ajouté');
        } else {
            session()->flash('erreurArticle', 'Un problème lors de l\'ajout de l\'article s\'est produit');
        }

        /* Gestion des mots clés*/
        $motsClesString = $validatedData['motClesArticle'];

        $motsClesArray = array_filter(array_map('trim', explode('#', $motsClesString)));
        foreach ($motsClesArray as $motCle) {
            /* Vérifie si le mot clé existe dans la table "Mot_Cle", si non il le crée et si oui, il y accède */
            $instanceMotCle = Mot_cle::where("mot_cle", $motCle)->firstOrCreate(["mot_cle" => $motCle]);
            if ($instanceMotCle == null) {
                session()->flash('erreurMotsCles', 'Un problème lors de l\'ajout des mots clés s\'est produit, veuillez réessayer.');
                #return->back();??
            }
            /* Vérifie si le mot clé existe dans la table "Mot_Cle_article", si non il le crée et si oui, il y accède */
            Mot_cle_article::where("id_mot_cle", $instanceMotCle->id_mot_cle)
                ->where("id_article", $newArticle->id_article)
                ->firstOrCreate([
                    "id_mot_cle" => $instanceMotCle->id_mot_cle,
                    "id_article" => $newArticle->id_article
                ]);
        }


        // Gestion du téléchargement de l'image
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile('photo' . $i)) {
                $file = $request->file('photo' . $i);
                $filename = time() . '.' . $file->getClientOriginalExtension(); // Générer un nom de fichier unique pour eviter le conflit de nom similaire
                $filePath = $file->storeAs('tests', $filename, 'public'); // Stocker dans le dossier 'photos' du disque public
                $file->move(public_path('img/tests'), $filename);
                $newPhotoArticle = new Photo_article();   /* Création de l'instance photo_article*/
                // Attribuer les données à l'instance
                $newPhotoArticle->id_article = $newArticle->id_article;
                $newPhotoArticle->path = $filePath;
                /* Stockage en BD de la nouvelle photo */
                if (!$newPhotoArticle->save()) {
                    session()->flash('erreurPhotos', 'Un problème lors de l\'ajout des photos s\'est produit, veuillez réessayer.');
                    #return->back();??
                }
            }
        }

        $idUser = Auth::user()->id;

        return redirect()->route('addArticleForm', ['idUser' => $idUser]);
    }

    /**
     * Display the specified resource.
     */
    public function show(article $article)
    {
        $idUser = Auth::user()->id;
        $artiste = Artiste::with("reseaux", "articles")->where('id_user', $idUser)->first();

        $articles = $artiste->articles;

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
        $searchTerm = $request->input('search');

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

        // Return the results to the view with the search term and matched articles
        return view('recherche.recherche', compact('articles', 'searchTerm'));
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
            $idArticle = $request->input("idArticle");

            $article = Article::where("id_article", $idArticle)->first();

            /* Changement de l'état (masqué aux clients et à l'artiste) */
            $article->id_etat = 3;

            /* Update de l'article en BD */
            if ($article->save()) {
                session()->flash('succesDeleteArticle', 'L\'article a bien été supprimé');
            } else {
                session()->flash('erreurDeleteArticle', 'Un problème lors de la suppression de l\'article s\'est produit');
            }

            $idUser = $request->input("idUser");

            return redirect()->route('kiosque', ['idUser' => $idUser]);
        } elseif ($request->routeIs('modifArticle')) {
            /* Validation des entrés */
            $validatedData = $request->validate([
                "idArtiste" => "required",
                "masquer" => "required|",
                "enVedette" => "required|in:0,1",
                "flouter" => "required|in:0,1",
                "prixArticle" => "required",
                "nomArticle" => "required|max:255",
                "pieceUnique" => "required|in:0,1",
                "descriptionArticle" => "required|max:512",
                "hauteurArticle" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01",
                "largeurArticle" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01",
                "profondeurArticle" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01",
                "poidsArticle" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01",
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
                "nomArticle.max" => "Le nom de l'article ne peut pas dépasser 255 caractères.",

                "pieceUnique.required" => "Le champ pièce unique est obligatoire.",
                "pieceUnique.in" => "La valeur du champ pièce unique doit être soit 'Unique' soit 'En série'.",

                "descriptionArticle.required" => "La description de l'article est obligatoire.",
                "descriptionArticle.max" => "La description de l'article ne peut pas dépasser 512 caractères.",

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

                "poidsArticle.required" => "Le poids de l'article est obligatoire.",
                "poidsArticle.numeric" => "Le poids de l'article doit être un nombre.",
                "poidsArticle.regex" => "Le poids de l'article doit être un nombre valide avec au maximum deux décimales.",
                "poidsArticle.min" => "Le poids de l'article doit être supérieur ou égal à 0.01.",

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

            /* Chercher l'article à modifier */
            $article = Article::where('id_article', $request->input("idArticle"))->first();

            /* Update de l'article*/
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
                session()->flash('succesArticle', 'L\'article à bien été modifié');
            } else {
                session()->flash('erreurArticle', 'Un problème lors de la modification de l\'article s\'est produit');
            }

            /* Gestion des mots clés*/
            # On supprime tous les anciennes liaisons pour en refaire des nouveaux meme si ce sont les mêmes.
            $article->motCles()->detach();

            $motsClesString = $validatedData['motClesArticle'];

            $motsClesArray = array_filter(array_map('trim', explode('#', $motsClesString)));
            foreach ($motsClesArray as $motCle) {
                /* Vérifie si le mot clé existe dans la table "Mot_Cle", si non il le crée et si oui, il y accède */
                $instanceMotCle = Mot_cle::where("mot_cle", $motCle)->firstOrCreate(["mot_cle" => $motCle]);
                if ($instanceMotCle == null) {
                    session()->flash('erreurMotsCles', 'Un problème lors de l\'ajout des mots clés s\'est produit, veuillez réessayer.');
                    #return->back();??
                }
                /* Cherche le mot clé dans la table de jonction et l'update */
                Mot_cle_article::where("id_mot_cle", $instanceMotCle->id_mot_cle)
                    ->where("id_article", $article->id_article)
                    ->firstOrCreate([
                        "id_mot_cle" => $instanceMotCle->id_mot_cle,
                        "id_article" => $article->id_article
                    ]);
            }

            // Gestion du téléchargement de l'image
            /*  for ($i = 1; $i <= 5; $i++) {
                if ($request->hasFile('photo' . $i)) {
                    $file = $request->file('photo' . $i);
                    $originalFilename = $file->getClientOriginalName(); // Récupérer le nom original
                    $filePath = 'tests/' . $originalFilename; // Chemin de stockage

                    // Vérifiez si le chemin de la photo existe déjà dans la base de données
                    $existingPhoto = Photo_article::where('path', $filePath)->first();

                    // Vérifiez également si le fichier existe déjà dans le stockage
                    $fileExistsInStorage = Storage::disk('public')->exists($filePath);

                    if (!$existingPhoto && !$fileExistsInStorage) {
                        // La photo n'existe pas encore, téléchargez-la
                        $file->storeAs('tests', $originalFilename, 'public'); // Stocker dans le dossier 'tests' du disque public

                        // Vérifiez si c'est une photo à remplacer
                        $photoId = $request->input('photoId' . $i); // Supposons que vous ayez des IDs de photos dans votre formulaire pour la suppression

                        if ($photoId) {
                            // Récupérer l'instance de la photo à remplacer
                            $photoToUpdate = Photo_article::find($photoId);

                            if ($photoToUpdate) {
                                // Mettre à jour le chemin de la photo
                                $photoToUpdate->path = $filePath;

                                // Enregistrer les changements
                                if (!$photoToUpdate->save()) {
                                    session()->flash('erreurPhotos', 'Un problème lors de la mise à jour des photos s\'est produit, veuillez réessayer.');
                                    #return back();
                                }
                            }
                        } else {
                            // Si aucune ID n'est fournie, c'est une nouvelle photo
                            $newPhotoArticle = new Photo_article();
                            $newPhotoArticle->id_article = $article->id_article;
                            $newPhotoArticle->path = $filePath;

                            // Stockage en BD de la nouvelle photo
                            if (!$newPhotoArticle->save()) {
                                session()->flash('erreurPhotos', 'Un problème lors de l\'ajout des photos s\'est produit, veuillez réessayer.');
                               # return back();
                            }
                        }
                    } else {
                        // La photo existe déjà soit dans la base de données soit dans le stockage
                        session()->flash('infoPhotos', 'La photo "' . $originalFilename . '" existe déjà.');
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
            } */

            return redirect()->route('modifArticleForm', ['idArticle' => $article->id_article]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(article $article) {}
}
