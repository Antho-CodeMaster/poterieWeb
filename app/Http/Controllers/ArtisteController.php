<?php

namespace App\Http\Controllers;

use App\Models\Artiste;
use App\Models\Reseau;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Reseau_artiste;
use Illuminate\Http\Request;

class ArtisteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($idUser)
    {
        $artiste = Artiste::with("reseaux","articles")->where('id_user', $idUser)->first();

        if (!$artiste) {
            // Gérer le cas où l'artiste n'est pas trouvé
            return redirect()->back()->with('error', 'Artiste non trouvé.');
        }

        /* Va chercher les reseaux et articles de l'artiste pour alléger le code dans la vue */
        $reseaux = $artiste->reseaux;

        /* Filtre les articles en fonctions de qui visite la page */
        if(Auth::id() == $artiste->id_user)
        {
            $articles = $artiste->articles;
        }
        else
        {
            $articles = [];
            foreach ($artiste->articles as $article){
                if($article->id_etat == 1)
                {
                    $articles[] = $article;
                }
            }
        }



        return view('kiosque/kiosque', [
            'artiste' => $artiste,
            'reseaux' => $reseaux,
            'articles' => $articles,
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
        return redirect()->route('profile.edit')
            ->with('status', 'picture-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(artiste $artiste)
    {
        //
    }
}
