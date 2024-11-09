<?php

namespace App\Http\Controllers;

use App\Models\Artiste;
use App\Models\Reseau;
use Illuminate\Support\Facades\Auth;
use App\Models\Reseau_artiste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Notification;

class ArtisteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($idUser)
    {
        /* 1. Aller chercher l'artiste en fonction de l'idUser */
        $artiste = Artiste::with("reseaux", "articles")->where('id_user', $idUser)->first();
        if (!$artiste) {
            // Gérer le cas où l'artiste n'est pas trouvé
            return redirect()->back()->with('error', 'Artiste non trouvé.');
        }

        /* 2. Vérifie si l'utilisateur est un artiste actif */
        if($artiste->actif == 0)
        {
            if (Auth::id() != $artiste->id_user){
                session()->flash('errorInactif', 'L\'artiste n\'existe pas');
                return redirect()->back();
            }

            session()->flash('errorInactif', 'Vous n\'est plus un artiste. Veuillez effectuer une nouvelle demande si vous voulez avoir accès à votre kiosque à nouveau.');
            return redirect()->back();
        }

        /* 3. Va chercher les reseaux et articles de l'artiste */
        $reseaux = $artiste->reseaux;

        /* Filtre les articles en fonctions de qui visite la page */
        if (Auth::id() == $artiste->id_user) {
            $articles = $artiste->articles;
        } else {
            $articles = [];
            foreach ($artiste->articles as $article) {
                if ($article->id_etat == 1) {
                    $articles[] = $article;
                }
            }
        }


        /* 4. Vérifie si l'artiste a des articles en vedette */
        $aDesArticlesVedette = collect($articles)->contains('is_en_vedette', true);

        /* 5. Vérifie si l'artiste a des articles */
        $aDesArticles = collect($articles)->isNotEmpty();

        // Va ouvrir un modal de bienvenue si c'est le premier accès de l'usager.
        if (request()->has('firstaccess'))
            Session::flash('firstaccess');

        return view('kiosque/kiosque', [
            'artiste' => $artiste,
            'reseaux' => $reseaux,
            'articles' => $articles,
            "enVedette" => $aDesArticlesVedette,
            "hasArticle" => $aDesArticles
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(artiste $artiste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, artiste $artiste)
    {
        //
    }

    /**
     * Update the artist's profile picture and saves it to img/artistePFP.
     */
    public function updatePicture(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',  // Validate file type and size
        ]);

        $artiste = $request->user()->artiste;

        // Check if an image was uploaded
        if ($request->hasFile('image')) {
            // Get the uploaded image
            $image = $request->file('image');

            // Generate a unique name for the image file
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Save the image in the public/img/artistePFP directory
            $image->move(public_path('img/artistePFP'), $imageName);

            // Update the artiste's path_photo_profil field with the new image path
            $artiste->path_photo_profil = 'img/artistePFP/' . $imageName;
        }

        // Save any other updates (you can add other fields you want to update here)
        $artiste->save();

        // Redirect back with a success message
        return redirect()->route('profile.personnaliser')
            ->with('status', 'picture-updated');
    }

    public function updateName(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255', // Customize validation rules as needed
        ]);

        $artiste = $request->user()->artiste;

        $artiste->nom_artiste = $request->input('name');

        // Save any other updates (you can add other fields you want to update here)
        $artiste->save();

        // Redirect back with a success message
        return redirect()->route('profile.personnaliser')
            ->with('status', 'artiste-name-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(artiste $artiste)
    {
        //
    }
}
