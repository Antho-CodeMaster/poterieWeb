<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Photo_oeuvre;
use App\Models\Photo_identite;
use App\Models\Notification;
use App\Models\Artiste;
use App\Models\User;
use App\Notifications\Acceptation_demande;
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
            'demandes' => Demande::where('id_etat', 1)->with(['photos_oeuvres', 'photos_identite'])->orderBy('date', 'asc')->get(),
            'images' => Storage::disk('public')
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index_traitees()
    {
        return view('admin/demandes-traitees', [
            'demandes' => Demande::where('id_etat', '!=', 1)->with(['photos_oeuvres', 'photos_identite'])->orderBy('updated_at', 'desc')->get(),
            'images' => Storage::disk('public')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return $request->getRequestUri() == "/renouvellement" ? view('demande.renouvellement') : view('demande.devenir-artiste');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Si on a déjà une demande pending, on ne peut pas en faire une nouvelle
        if (Demande::where('id_user', Auth::id())->where('id_etat', 1)->first() != null)
            return back()->withErrors(['alreadyPending' => 'Vous avez déjà une demande en attente dans notre serveur. Veuillez attendre le verdict de l\'administration avant de réessayer.']);

        // Assigner le bon type selon la demande
        $nomType = $request->input('type');
        if ($nomType == "etu")
            $type = 2;
        else if ($nomType == "pro")
            $type = 3;
        else
            return back()->withErrors(['msg' => 'Une erreur inattendue s\'est produite lors de l\'envoi de votre demande. Veuillez réessayer plus tard.']);

        // Si l'user veut un abonnement pro mais n'a pas défini de méthode de paiement, on ne peut pas lui créer de demande.
        if($type == 3)
        {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $customer = \Stripe\Customer::retrieve(Auth::user()->stripe_id);

            // Retrieve the customer's payment methods
            $paymentMethods = \Stripe\PaymentMethod::all([
                'customer' => $customer->id,
                'type' => 'card',
            ]);

            if($paymentMethods->data[0] == null)
                return back()->withErrors(['msg' => 'Vous devez définir une méthode de paiement dans vos paramètres afin de pouvoir payer votre abonnement si les administrateurs acceptent votre demande.']);
        }

        // Validation de base pour les photos de preuve
        $rules = [
            "photo-preuve" => "required|array|between:1,10",
            "photo-preuve.*" => "mimes:jpeg,png,jpg|max:2048"
        ];

        $messages = [
            "photo-preuve.required" => "Vous devez soumettre entre 1 et 10 photos à l'étape 1.",
            "photo-preuve.array" => "Vous devez soumettre entre 1 et 10 photos à l'étape 1.",
            "photo-preuve.between" => "Vous devez soumettre entre 1 et 10 photos à l'étape 1.",

            "photo-preuve.*.mimes" => "Toutes les photos doivent être des fichiers .jpeg, .png ou .jpg.",
            "photo-preuve.*.max" => "Toutes les photos doivent être moins lourdes que 2048 Ko.",
        ];

        // Valider qu'il y a bel et bien 3 photos et qu'elles sont dans le bon format si la demande est pour un étudiant
        if ($type == 2) {
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
        Session::flash('succesDemande', 'Votre demande a bel et bien été envoyée. Vous recevrez des nouvelles prochainement!');
        return redirect()->route('decouverte');
    }

    public function storeRenouvellement(Request $request)
    {
        // Si on a déjà une demande pending, on ne peut pas en faire une nouvelle
        if (Demande::where('id_user', Auth::id())->where('id_etat', 1)->first() != null)
            return back()->withErrors(['alreadyPending' => 'Vous avez déjà une demande en attente dans notre serveur. Veuillez attendre le verdict de l\'administration avant de réessayer.']);

        // Assigner le bon type selon la demande
        $nomType = $request->input('type');

        if ($nomType == "etu") {
            // Valider qu'il y a bel et bien 3 photos et qu'elles sont dans le bon format si la demande est pour un étudiant
            $rules['photo-identite'] = 'required|array|size:3';
            $rules['photo-identite.*'] = 'mimes:jpeg,png,jpg|max:2048';

            $messages['photo-identite.required'] = "Vous devez soumettre 3 photos à l'étape 2.";
            $messages['photo-identite.array'] = "Vous devez soumettre 3 photos à l'étape 2.";
            $messages['photo-identite.between'] = "Vous devez soumettre 3 photos à l'étape 2.";
            $messages['photo-identite.*.mimes'] = "Toutes les photos doivent être des fichiers .jpeg, .png ou .jpg.";
            $messages['photo-identite.*.max'] = "Toutes les photos doivent être moins lourdes que 2048 Ko.";

            // Performer la validation
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Stockage de la demande

            $newDemande = Demande::create([
                'id_type' => 1,
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
            if ($request->hasFile('photo-identite')) {
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
            Session::flash('succesDemande', 'Votre demande a bel et bien été envoyée. Vous recevrez des nouvelles prochainement!');
            return redirect()->route('decouverte');
        } else if ($nomType == "pro") {
            if(DemandeController::subscribe(Auth::id()))
            {
                Session::flash('succesRenouvellement', 'Votre abonnement a été confirmé. Vos accès à Terracium demeurent les mêmes. Merci!');
                //TODO: ENVOYER UN COURRIEL AVEC MODALITÉS D'ABONNEMENT
            }
            else{
                return back()->withErrors(['msg' => 'Une erreur inattendue s\'est produite lors du processus de votre abonnement. Veuillez confirmer la validité de votre carte ou réessayer plus tard.']);
            }
        } else
            return back()->withErrors(['msg' => 'Une erreur inattendue s\'est produite lors de l\'envoi de votre demande. Veuillez réessayer plus tard.']);

            return redirect()->route('decouverte');
        }


    public function subscribe(int $uid) : bool{
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        // Retrieve the customer
        $user = User::where("id", $uid)->first();

        if($user->stripe_id != null)
            $customer = \Stripe\Customer::retrieve($user->stripe_id);
        else return false;

        //S'assurer que le stripe customer existe
        if($customer == null)
            return false;

        // Retrieve the customer's payment methods
        $paymentMethods = \Stripe\PaymentMethod::all([
            'customer' => $customer->id,
            'type' => 'card',
        ]);

        if(empty($paymentMethods->data))
            return false;

        // Choose the payment method you want to use
        $paymentMethodId = $paymentMethods->data[0]->id;

        try {
            // Create the subscription
            $subscription = $user->newSubscription(
                'pro',
                env('subscription_pricekey')
            )->create($paymentMethodId);

            // Check if the subscription is active
            if ($user->subscribed('pro')) {
                return true;
            } else {
                dd($user->subscribed('pro'));
                return false;
            }

        } catch (\Exception $e) {
            // Handle any types of exceptions
            return false;
        }
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

        $usr = User::find($dem->id_user);

        if ($dem->id_type != 1) {
            if ($dem->id_type == 3) {
                if(DemandeController::subscribe($dem->id_user)){
                    //TODO: ENVOYER UN COURRIEL AVEC MODALITÉS D'ABONNEMENT
                }
                else{
                    return back()->withErrors(['refus' => 'Une erreur inattendue s\'est produite lors du processus de l\'abonnement. Le client a été notifié et devra faire une nouvelle demande.']);
                    //TODO: ENVOYER UN COURRIEL DISANT QUE LA DEMANDE EST ACCEPTÉE MAIS ABONNEMENT REFUSÉ
                }

            }
            // Créer instance d'artiste

            $artiste = Artiste::create([
                'id_user' => $dem->id_user,
                'id_theme' => 1,
                'nom_artiste' => null,
                'path_photo_profil' => 'img/artistePFP/default_artiste.png',
                'is_etudiant' => $dem->id_type == 2 ? true : false,
                'actif' => 1,
                'description' => null,
                'couleur_banniere' => '808080'
            ]);
            $artiste->save();
        } else {
            /* Traiter différemment s'il s'agit d'un renouvellement. */
            $artiste = Artiste::where("id_user", $dem->id_user)->first();
            $artiste->actif = 1;
            $artiste->save();
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
        $usr->notify(new Acceptation_demande($dem->id_user));

        Session::flash("succes", "L'utilisateur a bel et bien été accepté !");
        return redirect()->to(route('admin-demandes'));
    }

    /**
     * Refuser une demande.
     */
    public function deny()
    {
        if(request()->input('reason') == "" || request()->input('reason') == null)
            return back()->withErrors(['error' => "Veuillez spécifier une raison pour le refus."]);

        // Changer état demande
        $id = request()->query('id');

        $dem = Demande::where([
            'id_demande' => $id,
        ])->first();

        $dem->id_etat = 3;
        $dem->save();
        $usr = User::find($dem->id_user);

        if ($dem->id_type == 1) {
            /* Traiter différemment s'il s'agit d'un renouvellement refusé. */
            $usr->notify(new Renouvellement_refuse(request()->input('reason')));
            $artiste = Artiste::where("id_user", $dem->id_user)->first();
            $artiste->actif = 0;
            $artiste->save();
        }
        else
        {
            $usr->notify(new Refus_demande(request()->input('reason')));
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

        Session::flash("succes", "L'utilisateur a bel et bien été refusé !");
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
