<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Photo_oeuvre;
use App\Models\Photo_identite;
use App\Models\Notification;
use App\Models\Artiste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/demandes', [
            'demandes' => Demande::where('id_etat', 1)->with('photos_oeuvres')->with('photos_identite')->get(),
            'images' => Storage::disk('public')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('devenir-artiste');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Si on a déjà une demande pending, on ne peut pas en faire une nouvelle
        if (Demande::where('id_user', Auth::id())->where('id_etat', 1)->first() != null)
            return back()->withErrors(['msg' => 'Vous avez déjà une demande en attente dans notre serveur. Veuillez attendre le verdict de l\'administration avant de réessayer.']);

        // Assigner le bon type selon la demande
        $nomType = $request->input('type');
        if ($nomType == "etu")
            $type = 2;
        else if ($nomType == "pro")
            $type = 3;
        else
            return back()->withErrors(['msg' => 'Une erreur inattendue s\'est produite lors de l\'envoi de votre demande. Veuillez réessayer plus tard.']);

        // Validation de base pour les photos de preuve
        $rules = [
            "photo-preuve" => "required|array|between:1,10",
            "photo-preuve.*" => "mimes:jpeg,png,jpg|max:2048"
        ];

        // Valider qu'il y a bel et bien 3 photos et qu'elles sont dans le bon format si la demande est pour un étudiant
        if ($type == 2) {
            $rules['photo-identite'] = 'required|array|size:3';
            $rules['photo-identite.*'] = 'mimes:jpeg,png,jpg|max:2048';
        }

        // Performer la validation
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Stockage de la demande

        $newDemande = Demande::create([
            'id_type' => $type,
            'id_etat' => 1, // En attente
            'id_user' => Auth::id(),
            'date' => now()
        ]);
        if (!$newDemande->save()) {
            return back()->withErrors(['msg' => 'Une erreur inattendue s\'est produite lors de l\'envoi de votre demande. Veuillez réessayer plus tard.']);
        }

        $id_demande = $newDemande->id_demande;

        // Stockage des photos d'identité, seulement si l'utilisateur sera étudiant / renouvellement étudiant

        $cpt = 0;
        if ($request->hasFile('photo-identite')  && $type != 3) {
            $files = $request->file('photo-identite');
            foreach ($files as $file) {
                $filename = time() . '_' . $cpt . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/demandeIdentite'), $filename);
                $newPhoto = new Photo_identite();
                $newPhoto->id_demande = $id_demande;
                $newPhoto->path = $filename;
                if (!$newPhoto->save()) {
                    return back()->withErrors(['msg' => 'Une erreur inattendue s\'est produite lors de l\'envoi de votre demande. Veuillez réessayer plus tard.']);
                }
                $cpt++;
            }
        }

        // Stockage des photos d'oeuvre
        $cpt = 0;
        if ($request->hasFile('photo-preuve')) {
            $files = $request->file('photo-preuve');
            foreach ($files as $file) {
                $filename = time() . '_' . $cpt . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/demandePreuve'), $filename);
                $newPhoto = new Photo_oeuvre();
                $newPhoto->id_demande = $id_demande;
                $newPhoto->path = $filename;
                if (!$newPhoto->save()) {
                    return back()->withErrors(['msg' => 'Une erreur inattendue s\'est produite lors de l\'envoi de votre demande. Veuillez réessayer plus tard.']);
                }
                $cpt++;
            }
        }
        session()->flash('succesDemande', 'Votre demande a bel et bien été envoyée. Vous recevrez des nouvelles prochainement!');
        return redirect()->route('decouverte');
    }

    /**
     * Accepter une demande.
     */
    public function accept()
    {
        // Changer état demande
        $id = request()->query('id');

        $dem = Demande::where([
            'id_demande' => $id,
        ])->first();

        $dem->id_etat = 2;
        $dem->save();

        if ($dem->id_type != 1) {
            // Créer instance d'artiste

            $artiste = Artiste::create([
                'id_user' => $dem->id_user,
                'id_theme' => 1,
                'nom_artiste' => null,
                'path_photo_profil' => 'img/artistePFP/default_artiste.png',
                'is_etudiant' => $dem->id_type == 2 ? true : false,
                'description' => null,
                'couleur_banniere' => '808080'
            ]);
            $artiste->save();

            if($dem->id_type == 3)
            {
                /* Effectuer le paiement si pro. */
            }
        }
        else
        {
            /* Traiter différemment s'il s'agit d'un renouvellement. */
        }

        // Notifier user

        $notif = Notification::create([
            'id_type' => 3,
            'id_user' => $dem->id_user,
            'date' => now(),
            'message' => '',
            'lien' => null,
            'visible' => 1
        ]);
        $notif->save();

        /* Aussi notifier par courriel. */

        return redirect()->to(route('admin-demandes'));
    }

    /**
     * Refuser une demande.
     */
    public function deny()
    {
        // Changer état demande
        $id = request()->query('id');

        $dem = Demande::where([
            'id_demande' => $id,
        ])->first();

        $dem->id_etat = 3;
        $dem->save();

        if($dem->id_type == 1)
        {
            /* Traiter différemment s'il s'agit d'un renouvellement refusé. */
        }

        $notif = Notification::create([
            'id_type' => 2,
            'id_user' => $dem->id_user,
            'date' => now(),
            'message' => request()->input('reason'),
            'lien' => null,
            'visible' => 1
        ]);
        $notif->save();

        /* Aussi notifier par courriel. */

        return redirect()->to(route('admin-demandes'));
    }

    /**
     * Display the specified resource.
     */
    public function show(demande $demande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(demande $demande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, demande $demande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(demande $demande)
    {
        //
    }
}
