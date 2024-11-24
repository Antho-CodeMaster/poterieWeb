<?php

namespace App\Http\Controllers;

use App\Models\Artiste;
use App\Models\Reseau;
use Illuminate\Support\Facades\Auth;
use App\Models\Reseau_artiste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Stripe\Account as StripeAccount;
use Stripe\FinancialConnections\Account;

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
        if ($artiste->actif == 0) {
            if (Auth::id() != $artiste->id_user) {
                session()->flash('errorInactif', 'L\'artiste n\'existe pas');
                return redirect()->back();
            }

            session()->flash('errorInactif', 'Vous n\'est plus un artiste. Veuillez effectuer une nouvelle demande si vous voulez avoir accès à votre kiosque à nouveau.');
            return redirect()->back();
        }

        /* 3. Va chercher les reseaux et articles de l'artiste */
        $reseaux = $artiste->reseaux;

        /* Filtre les articles en fonction de qui visite la page */
        if (Auth::id() == $artiste->id_user) {
            // Si l'utilisateur est l'artiste, récupérer tous les articles
            $articles = $artiste->articles()->orderBy('created_at', 'desc')->get(); // Tri par date décroissante
        } else {
            // Si l'utilisateur n'est pas l'artiste, ne récupérer que les articles visibles
            $articles = $artiste->articles()->where('id_etat', 1)->orderBy('created_at', 'desc')->get(); // Tri par date décroissante
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

    public function updateColor(Request $request)
    {
        $artiste = Auth::user()->artiste;
        $color = str_replace('bg-', '', $request->input('couleur_banniere'));

        // Save the color to the artiste model
        $artiste->couleur_banniere = $color;
        $artiste->save();

        return redirect()->back()->with('status', 'kiosque-color-updated');
    }

    public function updateSocials(Request $request)
    {
        $artiste = Auth::user()->artiste;

        // Retrieve inputs
        $usernames = $request->input('usernames');
        $reseaux = $request->input('reseaux');
        $removedFields = json_decode($request->input('removed_fields'), true) ?? []; // Default to an empty array

        // Sanitize inputs
        $usernames = array_map(function ($username) {
            return strip_tags(str_replace(['"', "'"], '', trim($username))); // Remove HTML tags and trim
        }, $usernames ?? []); // Default to empty array if null
        $reseaux = array_map('intval', $reseaux ?? []); // Default to empty array if null
        $removedFields = array_filter($removedFields, function ($field) {
            if (isset($field['id_reseau'], $field['username']) &&
                is_numeric($field['id_reseau']) &&
                is_string($field['username'])) {
                $field['username'] = strip_tags(str_replace(['"', "'"], '', trim($field['username']))); // Clean username
                $field['id_reseau'] = (int) $field['id_reseau'];
                return true;
            }
            return false;
        });

        // Detach removed fields
        if (!empty($removedFields)) {
            foreach ($removedFields as $field) {
                $reseau_id = $field['id_reseau'];
                $username = $field['username'];

                $artiste->reseaux()
                    ->wherePivot('id_reseau', $reseau_id)
                    ->wherePivot('username', $username)
                    ->detach();
            }

            foreach ($removedFields as $field) {
                $reseau_id = $field['id_reseau'];
                $username = $field['username'];

                $index = array_search($reseau_id, $reseaux);
                if ($index !== false && $usernames[$index] === $username) {
                    unset($reseaux[$index]);
                    unset($usernames[$index]);
                }
            }

            $reseaux = array_values($reseaux);
            $usernames = array_values($usernames);
        }

        // Add or update remaining fields
        foreach ($reseaux as $index => $reseau_id) {
            $username = $usernames[$index];

            if (!is_int($reseau_id) || empty($username)) {
                continue;
            }

            $existingPivot = $artiste->reseaux()
                ->wherePivot('id_reseau', $reseau_id)
                ->wherePivot('username', $username)
                ->first();

            if ($existingPivot) {
                $artiste->reseaux()->updateExistingPivot($reseau_id, ['username' => $username]);
            } else {
                $artiste->reseaux()->attach($reseau_id, ['username' => $username]);
            }
        }

        return redirect()->back()->with('status', 'social-media-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(artiste $artiste)
    {
        //
    }


}
