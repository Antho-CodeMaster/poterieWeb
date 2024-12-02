<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Photo_oeuvre;
use App\Models\Photo_identite;
use App\Models\Notification;
use App\Models\Artiste;
use App\Models\User;
use App\Notifications\Acceptation_etudiant;
use App\Notifications\Acceptation_pro;
use App\Notifications\Refus_demande;
use App\Notifications\Renouvellement_refuse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/demandes', [
            'demandes' => Demande::where('id_etat', 1)->with(['photos_oeuvres', 'photos_identite'])->orderBy('created_at', 'asc')->get(),
            'images' => Storage::disk('public')
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index_traitees(Request $request)
    {
        $page = $request->input('page', 1);

        $demandes = Demande::where('id_etat', '!=', 1)->with(['photos_oeuvres', 'photos_identite'])->orderBy('updated_at', 'desc');
        $count = $demandes->count();
        $demandes = $demandes->skip(50 * ($page - 1))
            ->take(50)
            ->get();

        return view(
            'admin/demandes-traitees',
            [
                'demandes' => $demandes,
                'page' => $page - 1,
                'count' => $count,
                'total_pages' => ceil($count / 50),
                'images' => Storage::disk('public')
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $view = $request->getRequestUri() == "/renouvellement"
            ? view('demande.renouvellement')
            : view('demande.devenir-artiste');

        $demande = Demande::where('id_user', Auth::id())->where('id_etat', 1)->first();

        // Si on a déjà une demande pending, on ne peut pas en faire une nouvelle
        if (Demande::where('id_user', Auth::id())->where('id_etat', 1)->first() != null)
            return $view->withErrors([
                'alreadyPending' => 'Vous avez déjà une demande en attente dans notre serveur, créée le ' . $demande->created_at . '. Veuillez attendre le verdict de l\'administration avant de réessayer.'
            ]);

        return $view;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Si on a déjà une demande pending, on ne peut pas en faire une nouvelle
        if (Demande::where('id_user', Auth::id())->where('id_etat', 1)->exists())
            return back()->withErrors(['alreadyPending' => 'Vous avez déjà une demande en attente dans notre serveur. Veuillez attendre le verdict de l\'administration avant de réessayer.']);

        // Assigner le bon type selon la demande
        $nomType = $request->input('type');

        if ($nomType == "ren")
            $type = 1;
        else if ($nomType == "etu")
            $type = 2;
        else if ($nomType == "pro")
            $type = 3;
        else
            return back()->withErrors(['msg' => 'Une erreur inattendue s\'est produite lors de l\'envoi de votre demande. Veuillez réessayer plus tard.']);

        $rules = [];
        $messages = [];

        // Validations si c'est une demande pour un nouvel artiste

        if ($type != 1) {
            // Validation de base pour les photos de preuve
            $rules["photo-preuve"] = "required|array|between:1,10";
            $rules["photo-preuve.*"] = "mimes:jpeg,png,jpg|max:2048";

            $messages["photo-preuve.required"] = "Vous devez soumettre entre 1 et 10 photos à l'étape 1.";
            $messages["photo-preuve.array"] = "Vous devez soumettre entre 1 et 10 photos à l'étape 1.";
            $messages["photo-preuve.between"] = "Vous devez soumettre entre 1 et 10 photos à l'étape 1.";

            $messages["photo-preuve.*.mimes"] = "Toutes les photos doivent être des fichiers .jpeg, .png ou .jpg.";
            $messages["photo-preuve.*.max"] = "Toutes les photos doivent être moins lourdes que 2048 Ko.";
        }

        // Validations de photo d'identité si la demande n'est pas pour un pro
        if ($type != 3) {
            $rules['photo-identite'] = 'required|array|size:3';
            $rules['photo-identite.*'] = 'mimes:jpeg,png,jpg|max:2048';

            $messages['photo-identite.required'] = "Vous devez soumettre 3 photos à l'étape 2.";
            $messages['photo-identite.array'] = "Vous devez soumettre 3 photos à l'étape 2.";
            $messages['photo-identite.between'] = "Vous devez soumettre 3 photos à l'étape 2.";
            $messages['photo-identite.*.mimes'] = "Toutes les photos doivent être des fichiers .jpeg, .png ou .jpg.";
            $messages['photo-identite.*.max'] = "Toutes les photos doivent être moins lourdes que 2048 Ko.";
        }

        // Performer la validation
        $validator = Validator::make($request->all(), $rules, $messages);

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
        if ($request->hasFile('photo-preuve') && $type != 1) {
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
        Session::flash('succesDemande', 'Votre demande a bel et bien été envoyée. Vous recevrez des nouvelles prochainement!');
        return redirect()->route('decouverte');
    }

    /**
     * Accepter une demande.
     */
    public function accept()
    {
        // Charger id de la personne à accepter
        $id = request()->query('id');

        // Retrouver la demande
        $dem = Demande::where([
            'id_demande' => $id,
        ])->first();

        // Mettre à jour son état
        $dem->id_etat = 2;
        $dem->save();

        // Charger l'utilisateur lié à la demande
        $usr = User::find($dem->id_user);

        switch ($dem->id_type) {
                // S'il s'agit d'un renouvellement étudiant, simplement remettre l'étudiant actif.
            case 1:
                $artiste = Artiste::where("id_user", $dem->id_user)->first();
                $artiste->actif = 1;
                $artiste->save();
                break;

                // S'il s'agit d'une demande pour devenir étudiant, créer la ressource avec les valeurs appropriées.
            case 2:
                $artiste = Artiste::create([
                    'id_user' => $dem->id_user,
                    'nom_artiste' => null,
                    'path_photo_profil' => 'img/artistePFP/default_artiste.png',
                    'is_etudiant' => true,
                    'actif' => 1,
                    'description' => null,
                    'couleur_banniere' => '808080'
                ]);
                $artiste->save();
                $usr->notify(new Acceptation_etudiant($dem->id_user));
                // Notifier user

                $notif = Notification::create([
                    'id_type' => 3,
                    'id_user' => $dem->id_user,
                    'date' => now(),
                    'message' => '',
                    'lien' => route('kiosque', ['idUser' => $dem->id_user]) . '?firstaccess=true',
                    'visible' => 1
                ]);
                $notif->save();
                break;
                // S'il s'agit d'une demande pour devenir professionnel, créer la ressource avec les valeurs appropriées.
            case 3:
                $artiste = Artiste::create([
                    'id_user' => $dem->id_user,
                    'nom_artiste' => null,
                    'path_photo_profil' => 'img/artistePFP/default_artiste.png',
                    'is_etudiant' => false,
                    'actif' => false, //Car l'artiste doit payer pour activer son abonnement
                    'description' => null,
                    'couleur_banniere' => '808080'
                ]);
                $artiste->save();
                $usr->notify(new Acceptation_pro($dem->id_user));
                // Notifier user

                $notif = Notification::create([
                    'id_type' => 5,
                    'id_user' => $dem->id_user,
                    'date' => now(),
                    'message' => '',
                    'lien' => route('abonnement'),
                    'visible' => 1
                ]);
                $notif->save();
                break;
        }

        Session::flash("succes", "L'utilisateur a bel et bien été accepté !");
        return back();
    }

    /**
     * Refuser une demande.
     */
    public function deny()
    {
        // S'assurer qu'une raison aie été spécifiée.
        if (request()->input('reason') == "" || request()->input('reason') == null)
            return back()->withErrors(['error' => "Veuillez spécifier une raison pour le refus."]);

        // Charger l'ID de l'utilisateur concerné.
        $id = request()->query('id');

        // Retrouver la demande
        $dem = Demande::where([
            'id_demande' => $id,
        ])->first();

        // Changer son état
        $dem->id_etat = 3;
        $dem->raison_refus = request()->input('reason');
        $dem->save();

        // Charger l'utilisateur concerné
        $usr = User::find($dem->id_user);

        // S'il s'agit d'un renouvellement refusé, en informer l'utilisateur de la manière appropriée.
        if ($dem->id_type == 1) {
            // Envoyer un courriel
            $usr->notify(new Renouvellement_refuse($dem->raison_refus));

            // Rendre l'artiste inactif
            $artiste = Artiste::where("id_user", $dem->id_user)->first();
            $artiste->actif = 0;
            $artiste->save();
        } else {
            // Envoyer un courriel
            $usr->notify(new Refus_demande($dem->raison_refus));
        }

        // Notifier in=app concernant le refus
        $notif = Notification::create([
            'id_type' => 2,
            'id_user' => $dem->id_user,
            'date' => now(),
            'message' => request()->input('reason'),
            'lien' => null,
            'visible' => 1
        ]);
        $notif->save();

        Session::flash("succes", "L'utilisateur a bel et bien été refusé !");
        return back();
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
