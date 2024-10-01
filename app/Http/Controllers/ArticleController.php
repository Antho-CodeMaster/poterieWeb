<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Mot_cle;
use App\Models\Mot_cle_article;
use App\Models\Photo_article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* Validation des entrés */
        $validatedData = $request->validate([
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
            "motClesArticle" => "nullable|regex:/^#[a-zA-Z0-9]+(#[a-zA-Z0-9]+)*$/",
            "photo1" => "nullable|image|mimes:jpeg,png,jpg|max:2048'",
            "photo2" => "nullable|image|mimes:jpeg,png,jpg|max:2048'",
            "photo3" => "nullable|image|mimes:jpeg,png,jpg|max:2048'",
            "photo4" => "nullable|image|mimes:jpeg,png,jpg|max:2048'",
            "photo5" => "nullable|image|mimes:jpeg,png,jpg|max:2048'",
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
        ]);

        /* Création de l'article */
            $newArticle = new Article();

        // Attribuer les données à l'instance
            $newArticle->id_artiste = $validatedData['idArtiste'];
            $newArticle->id_etat = $validatedData['masquer'];
            $newArticle->nom = $validatedData['nomArticle'];
            $newArticle->description = $validatedData['descriptionArticle'];
            $newArticle->prix = $validatedData["prixArticle"];
            $newArticle->hauteur = $validatedData['hauteurArticle'];
            $newArticle->largeur = $validatedData['largeurArticle'];
            $newArticle->profondeur = $validatedData['profondeurArticle'];
            $newArticle->poids = $validatedData['poidsArticle'];
            $newArticle->quantite_disponible = $validatedData['quantiteArticle'];
            $newArticle->date_publication = (new \DateTime())->format('Y-m-d H:i:s');
            $newArticle->is_en_vedette = $validatedData['enVedette'];
            $newArticle->is_sensible = $validatedData['flouter'];
            $newArticle->is_alimentaire = $validatedData['typePiece'];
            $newArticle->is_unique = $validatedData['pieceUnique'];
            $newArticle->couleur = "brun marde"; /* On devrait dropper cette attribut puisqu'on gère les mots clés */

            $newArticle->save(); /* Stockage en BD du nouvelle article */

        /* Gestion des mots clés*/
            $motsClesString = $validatedData['motClesArticle'];

            $motsClesArray = array_filter(array_map('trim', explode('#', $motsClesString)));
            foreach ($motsClesArray as $motCle) {
                /* Vérifie si le mot clé existe dans la table "Mot_Cle", si non il le crée et si oui, il y accède */
                $instanceMotCle = Mot_cle::where("mot", $motCle)->firstOrCreate(["mot" => $motCle]);
                /* Vérifie si le mot clé existe dans la table "Mot_Cle_article", si non il le crée et si oui, il y accède */
                Mot_cle_article::where("id_mot_cle",$instanceMotCle->id_mot_cle, "and", "id_article", $newArticle->id_article)->firstOrCreate(["id_mot_cle" => $instanceMotCle->id_mot_cle, "id_article" => $newArticle->id_article]);
            }


        // Gestion du téléchargement de l'image
            for ($i = 1; $i <= 5; $i++) {
                if ($request->hasFile('photo'.$i)) {
                    $file = $request->file('photo'.$i);
                    $filename = time() . '.' . $file->getClientOriginalExtension(); // Générer un nom de fichier unique pour eviter le conflit de nom similaire
                    $filePath = $file->storeAs('img', $filename, 'public'); // Stocker dans le dossier 'photos' du disque public
                    $newPhotoArticle = new Photo_article();   /* Création de l'instance photo_article*/
                    // Attribuer les données à l'instance
                    $newPhotoArticle->id_article = $newArticle->id_article;
                    $newPhotoArticle->path = $filePath;
                    $newPhotoArticle->save(); /* Stockage en BD de la nouvelle photo */
                }
            }

        return redirect()->route('kiosque')->with("success", "Article créé avec succès!");
    }

    /**
     * Display the specified resource.
     */
    public function show(article $article)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(article $article)
    {
        //
    }
}
