<?php

namespace App\Http\Controllers;

use App\Models\Artiste;
use App\Models\Article;
use App\Models\Transaction;
use App\Models\Commande;
use App\Models\Compagnie_livraison;
use App\Models\Photo_livraison;
use App\Models\Photo_oeuvre;
use App\Models\EasyPost;
use EasyPost\Tracker;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Stripe\Invoice;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class TransactionController extends Controller
{
    #===========================================#
    #        PARAMÈTRES ET CONSTRUCTEUR         #
    #===========================================#
    protected $easyPost;

    public function __construct()
    {
        $this->easyPost = new EasyPost();
    }

    #===========================================#
    #          Fonctions qui display            #
    #===========================================#

    /**
     * Montre les commandes de l'artiste a traiter
     */
    public function mesTransactions($idUser)
    {
        /* 1. Récupérer le id de l'artiste */
        $idArtiste = Artiste::where('id_user', $idUser)->pluck('id_artiste')->first();

        /* 2. Récupérer les articles de l'artiste */
        $articles = Article::where('id_artiste', $idArtiste)->get();

        /* 3. Créer un array contenant que les id de chaque article */
        $articleIds = $articles->pluck('id_article')->toArray();

        /* 4. Récupérer les transactions en lien avec les articles de l'artiste*/
        $transactions = Transaction::whereIn('id_article', $articleIds)->get();

        /* 5. Regrouper les transaction par commande */
        $commandeTransactions = $transactions->groupBy('id_commande');

        /* 6. Placer les commandes en fonction de ceux qui contiennent le plus de transaction non traité et de la date*/
        $commandeTransactions = $commandeTransactions->sortByDesc(function ($transactions) {
            # Compter les transactions non traitées dans chaque commande (id_etat 2 = en attente)
            return $transactions->where('id_etat', 2)->count();
        })->sortByDesc(function ($transactions) {
            # Puis trier par la date de commande (plus récente en premier)
            return $transactions->first()->commande->date;
        });

        /* 7. Récupérer les public URL de chaque transaction */
        $urlArray = [];
        foreach ($commandeTransactions as $transactions) {
            // Filtrer uniquement les transactions livrées (id_etat == 3)
            $livreeTransactions = $transactions->where('id_etat', 3);

            foreach ($livreeTransactions as $transaction) {
                $urlArray[$transaction->id_transaction] = $this->getTrackerURL($transaction); # Associe l'URL avec l'ID de la transaction
            }
        }

        /* 8. Retourner la vue 'Mes commandes' avec un array d'article, de transaction et d'url */
        return view('commande.commandesArtiste', [
            'articles' => $articles,
            'commandeTransactions' => $commandeTransactions,
            'urlArray' => $urlArray
        ]);
    }

    /**
     * Fonction pour filtrer les transactions dans la commandes
     */
    public function commandesFiltre(Request $request)
    {
        // 1. Récupérer les valeurs des filtres envoyés depuis le client
        $dateFiltre = $request->input('dateFilter');
        $dateFiltre = $dateFiltre ?? '1'; # Pour filtrer en ordre croissant toujours si aucun filtre

        $compagnieFilter = $request->input('compagnieFilter');
        $statutFilter = $request->input('statutFilter');
        $searchTerm = $request->input('searchTransaction');

        // 2. Récupérer l'artiste connecté
        $artiste = Artiste::where('id_user', $request->input("idArtiste"))->first();

        /* 3. Récupérer les articles de l'artiste */
        $articles = Article::where('id_artiste', $artiste->id_artiste)->get();

        /* 3. Créer un array contenant que les id de chaque article */
        $articleIds = $articles->pluck('id_article')->toArray();

        /* 4. Commencer la requête pour filtrer les commandes liées aux transactions */
        $commandeTransactions = Transaction::whereIn('id_article', $articleIds)
            ->when(!empty($compagnieFilter) && $compagnieFilter !== 'null', function ($query) use ($compagnieFilter) {
                # Filtrer par compagnie si défini
                $query->where('id_compagnie', $compagnieFilter);
            })
            ->when(!empty($statutFilter) && $statutFilter !== 'null', function ($query) use ($statutFilter) {
                # Filtrer par statut si défini
                $query->where('id_etat', $statutFilter);
            })
            ->when(!empty($searchTerm) && $searchTerm !== 'null', function ($query) use ($searchTerm) {
                $query->whereHas('article', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('nom', 'LIKE', '%' . $searchTerm . '%');
                })->orWhereHas('commande.user', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('name', 'LIKE', '%' . $searchTerm . '%');
                });
            })
            ->whereIn('id_article', $articleIds)
            ->get()
            ->groupBy('id_commande') # Grouper par commande
            ->sortByDesc(function ($transactions) {
                # Trier pour afficher les commandes avec le plus de transactions en cours (`id_etat = 2`) en premier
                return $transactions->where('id_etat', 2)->count();
            })
            ->sortBy(function ($transactions) use ($dateFiltre) {
                # Trier par date de commande (croissant ou décroissant selon `dateFiltre`)
                $date = $transactions->first()->commande->date ?? null;
                return $dateFiltre === '0' ? $date : -strtotime($date);
            });

        try {
            /* 5. Récupérer les public URL de chaque transaction */
            $urlArray = [];

            $urlArray = [];
            foreach ($commandeTransactions as $transactions) {
                // Filtrer uniquement les transactions livrées (id_etat == 3)
                $livreeTransactions = $transactions->where('id_etat', 3);

                foreach ($livreeTransactions as $transaction) {

                    $idTransaction = $transaction->id_transaction;

                    $urlArray[$idTransaction] = Cache::remember("tracker_url_$idTransaction", now()->addHours(6), function () use ($transaction) {
                        return $this->getTrackerURL($transaction);
                    });
                }
            }

            $view = view('commande.partials.allTransactions', compact('commandeTransactions', 'artiste', 'urlArray'))->render();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }

        /* 6. Retourner les articles sous forme de JSON */
        return response()->json([
            'status' => 'success',
            'html' => $view,
            'commandeTransactions' => $commandeTransactions,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($idTransaction)
    {
        /* 1. Récupérer la transaction concernée */
        $transaction = Transaction::findOrFail($idTransaction);

        /* 2. Envoyer la liste de compagnie de livraison */
        $compagnies = Compagnie_livraison::all();

        /* 3. Retourner la vue avec les variable transaction et compagnie */
        return view("commande.traiterTransactionForm")->with("transaction", $transaction)->with("compagnies", $compagnies);
    }

    #===========================================#
    #             Fonctions EasyPost            #
    #===========================================#

    /**
     *  Met à jour l'état de la transaction à l'aide de EasyPost
     */
    public function getStatut(Transaction $transaction)
    {
        /* 1. Récupère le trackingId de la transaction*/
        $trackingId = $transaction->trackingId_easypost;

        /* 2. Requête à l'api EasyPost pour récupérer le statut */
        $statut = $this->easyPost->getStatus($trackingId);

        // Déterminer le nouvel état en fonction du statut
        switch ($statut) {
            case 'pre_transit':
            case 'in_transit':
            case 'out_for_delivery':
                return 3; # Statut traité
            case 'delivered':
            case 'available_for_pickup':
                return 4; # Statut livré
            case 'cancelled':
            case 'failure':
            case 'error':
                return 5; # Statut annulé
            default:
                Log::warning("Statut inconnu retourné par EasyPost: {$statut}"); # Statut inconnu
                return null;
        }
    }

    /**
     *  Met à jour l'état de la transaction à l'aide de EasyPost et met à jour la transaction en BD
     */
    public function setStatut(Transaction $transaction)
    {
        /* 1. Requête à l'api EasyPost pour récupérer le statut */
        $statut = $this->getStatut($transaction);

        /* 2. Mettre à jour l'état en fonction du statut */
        $transaction->update([
            'id_etat' => $statut,
        ]);
    }

    /**
     *  Met à jour la date de livraison prévue à l'aide de EasyPost
     */
    public function getEstimatedDeliveryDate(Transaction $transaction)
    {
        /* 1. Récupère le trackingId de la transaction*/
        $trackingId = $transaction->trackingId_easypost;

        /* 2. Requête à l'api EasyPost pour récupérer la date de réception prévue */
        $estimatedDelivery = $this->easyPost->getEstimatedDelivery($trackingId);

        /* 3. Retourne la date de réception prévue sous le bon format */
        return $estimatedDelivery;
    }

    /**
     *  Met à jour la date de livraison prévue à l'aide de EasyPost et met à jour la transaction en BD
     */
    public function setEstimatedDeliveryDate(Transaction $transaction)
    {
        /* 1. Requête à l'api EasyPost pour récupérer la date de réception prévue */
        $estimatedDelivery = $this->getEstimatedDeliveryDate($transaction);

        /* 2. Mettre à jour la date de réception prévue en fonction de la date estimée de livraison*/
        $transaction->update([
            'date_reception_prevue' => $estimatedDelivery,
        ]);
    }

    /**
     *  Met à jour la date de livraison effective à l'aide de EasyPost
     */
    public function getDeliveryDate(Transaction $transaction)
    {
        /* 1. Récupère le trackingId de la transaction */
        $trackingId = $transaction->trackingId_easypost;

        /* 2. Requête à l'api EasyPost pour récupérer la date de réception livré */
        $dateDelivery = $this->easyPost->getDeliveryDate($trackingId);

        /* 3. Retourne la date de réception livré sous le bon format */
        return $dateDelivery;
    }

    /**
     *  Met à jour la date de livraison effective à l'aide de EasyPost et met à jour la transaction en BD
     */
    public function setDeliveryDate(Transaction $transaction)
    {
        /* 1. Requête à l'api EasyPost pour récupérer la date de réception livré */
        $dateDelivery = $this->getDeliveryDate($transaction);

        /* 2. Mettre à jour la date de réception livré en fonction de la date de livraison*/
        if ($dateDelivery != 'Not delivered yet' && $dateDelivery != null) { # Si une date est retourné
            $transaction->update([
                'date_reception_effective' => $dateDelivery,
            ]);
        } else { # Si aucune date n'est retourné
            $transaction->update([
                'date_reception_effective' => null,
            ]);
        }
    }

    /**
     *  Met à jour la date de livraison effective à l'aide de EasyPost
     */
    public function getTrackerURL(Transaction $transaction)
    {
        /* 1. Récupère le trackingId de la transaction */
        $trackingId = $transaction->trackingId_easypost;

        /* 2. Requête à l'api EasyPost pour récupérer le public URL */
        $publicURL = $this->easyPost->getTrackerURL($trackingId);

        /* 3. Retourne le public URL */
        return $publicURL;
    }


    /**
     * Met à jour une transaction à l'aide d'un événement reçu via le webhook EasyPost
     */
    public function updateWithWebHook(Request $request)
    {
        /* 1. Récupère le trackingId de l'évenement */
        $trackingId = $this->easyPost->getTrackerEvent($request);

        /* 2. Recherche la transaction en BD lié à ce trackingId */
        $transaction = Transaction::where("trackindId_easypost", $trackingId);

        /* 3. Mettre à jour tous ses information en fonction des données reçues */
        $this->setStatut($transaction); # Met à jour le statut
        $this->setEstimatedDeliveryDate($transaction); # Met à jour la date de livraison prévue
        $this->setDeliveryDate($transaction); # Met à jour la date de livraison effective

        dump("Event recu \n" . "TrackingId : " . $trackingId);
    }

    #===========================================#
    #       Fonctions update et stockage        #
    #===========================================#

    /**
     * Store a new transaction
     * User connecté : $request['id_commande'] (à récupérer avec CommandeController->getPanier)
     * id_article nécessaire, quantité de 1. Modifiable dans un formulaire avec une autre fonction.
     */
    public function store(Request $request)
    {
        #Créé une entrée transaction pour l'utilisateur connecté
        if (Auth::check()) {
            //Get le panier ou on le créé
            $commande = Commande::firstOrCreate(
                ['id_user' => Auth::id(), 'is_panier' => true]
            );

            //get si la transaction existe deja ou en créé une nouvelle
            $transaction = Transaction::firstOrCreate(
                [
                    'id_commande' => $commande->id_commande,
                    'id_article' => $request->input('id_article')
                ],
                ['quantite' => 1, 'id_etat' => 2]
            );
            $transaction->update(['prix_unitaire' => $transaction->article->prix]);

            //incémente la quantité (0+1 si nouvelle)
            return Redirect::back(302, ['message' => 'Succes: Article ajouté au panier']);
        }
        #Créé un cookie qui store le panier si l'utilisateur n'est pas connecté
        else {
            #récupère le cookie déja existant (sinon on en créé un vide)
            $panier = json_decode($request->cookie('panier', ''), true);

            $id_article = $request->input('id_article');

            $panier[$id_article] = [
                'id_article' => $id_article,
                'quantite' => 1
            ];


            #Update le cookie pour un 30j d'activité après avoir ajouté un article
            $biscuit = cookie('panier', json_encode($panier), 60 * 24 * 30);

            return Redirect::back()->withCookie($biscuit);
            // return response('Article ajouté au panier (biscuit)')->cookie($biscuit);
        }
    }

    /**
     * Update la transaction
     */
    public function update(Request $request)
    {
        if (Auth::check()) {

            if ($request->routeIs('traiterTransaction')) {

                /* 1. Récupérer et valider les données du form */
                $validatedData = $request->validate([
                    "idTransaction" => "required",
                    "compagnieLivraison" => "required",
                    "codeRefLivraison" => "required",
                    "photo1" => "required|mimes:jpeg,png,jpg",
                    "photo2" => "mimes:jpeg,png,jpg",
                ], [
                    "compagnieLivraison.required" => "La compagnie de livraison est obligatoire.",
                    "codeRefLivraison.required" => "Le numéro de tracking de la livraison est obligatoire.",
                    'photo1.mimes' => 'La photo 1 doit être au format JPEG, PNG ou JPG.',
                    'photo1.required' => 'Il doit y avoir au moins 1 photo de livraison afin de traiter une transaction correctement',
                    'photo2.mimes' => 'La photo 2 doit être au format JPEG, PNG ou JPG.',
                ]);

                // 2. Récupérer la transaction
                $transaction = Transaction::where("id_transaction", $validatedData["idTransaction"])->first();
                if (!$transaction) {
                    session()->flash('erreurTransaction', 'Transaction introuvable.');
                    return back();
                }

                /* 3. Gestion des photos de livraisons */
                for ($i = 1; $i <= 2; $i++) {
                    if ($request->hasFile('photo' . $i)) {
                        $file = $request->file('photo' . $i);

                        // Créer un nom de fichier unique avec un identifiant aléatoire
                        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                        // Stocker le fichier dans le répertoire public
                        $filePath = $file->storeAs('tests', $filename, 'public');

                        // Déplacer le fichier vers le dossier public (optionnel, dépendant de votre configuration)
                        $file->move(public_path('img/tests'), $filename);

                        /* Ajouter la données dans la BD */
                        $newPhotoLivraison = new Photo_livraison();
                        $newPhotoLivraison->id_transaction = $transaction->id_transaction;
                        $newPhotoLivraison->path = $filePath; // Stockage du chemin exact en base de données

                        if (!$newPhotoLivraison->save()) {
                            session()->flash('erreurPhotos', 'Un problème lors de l\'ajout des photos s\'est produit, veuillez réessayer.');
                            return back();
                        }
                    }
                }


                /* 5. Création d'un tracker EasyPost avec le nom de la compagnie et le numéro de suivie*/
                # Récupérer le nom de la compagnie de livraison
                $compagnie = Compagnie_livraison::find($validatedData['compagnieLivraison']);
                if (!$compagnie) {
                    session()->flash('erreurCompagnieLivraison', 'La compagnie de livraison spécifiée est introuvable.');
                    return back();
                }

                # Reformate le nom de Postes Canada
                $compagnieNom = $compagnie->compagnie; // Supposons que le nom est stocké dans la colonne 'nom'
                if ($compagnieNom == "Postes Canada") {
                    $compagnieNom = "CanadaPost";
                }

                # Création du tracker
                $tracker = $this->easyPost->createTracker(
                    $validatedData['codeRefLivraison'],
                    $compagnieNom
                );

                # Ajout du trackingId dans l'instance de la transaction
                $transaction->update([
                    "trackingId_easypost" => $tracker->id,
                ]);

                /* 6. Mise à jour de la transaction */
                $transaction->update([
                    'code_ref_livraison' => $validatedData['codeRefLivraison'],
                    'id_compagnie' => $validatedData['compagnieLivraison'],
                    'date_reception_prevue' => $this->getEstimatedDeliveryDate($transaction),
                    'id_etat' => $this->getStatut($transaction),
                ]);

                /* 7. Retour à la vue "mesTransactions" */
                session()->flash('succesTransaction', 'La transaction a bien été traitée');
                return redirect()->route('mesTransactions', ['idUser' => Auth::user()->id]);
            }
        }
    }

    /**
     * Update de la quantite
     */
    public function updateQt(Request $request)
    {

        $validated = $request->validate([
            'transaction_id' => 'nullable|exists:transactions,id_transaction',
            'quantity' => 'required|integer|min:1',
            'article_id' => 'required|integer',
        ]);


        if (Auth::check()) {
            // Logged-in user

            if ($validated['transaction_id']) {
                // Update the transaction in the database

                $transaction = Transaction::where('id_transaction', $validated['transaction_id'])
                    ->firstOrFail();

                $transaction->update(['quantite' => $validated['quantity']]);

                return response()->json(['status' => 'ok']);
            }
        } else {

            $panier = json_decode($request->cookie('panier', '[]'), true);

            $panier[$validated['article_id']] = [
                'id_article' => $validated['article_id'],
                'quantite' => $validated['quantity']
            ];

            /*foreach ($panierData as $item) {
                try {
                    if ($qte > Article::first($item['Article'])->quantite_disponible || $qte < 0) {
                        throw new Exception('Failed to update, Quantity out of bound');
                    }

                    $panier[$item['Article']]['quantite'] = $item['quantite'];
                } catch (Exception $e) {
                    return response(400)->json()->withException($e);
                }
            }*/

            $biscuit = cookie('panier', json_encode($panier), 60 * 24 * 30);

            return response()->json(['message' => 'Success, quantity data updated'])->withCookie($biscuit);
        }
    }

    /**
     * Remove the specified resource from storage.
     * works for connected users
     */

    public function destroy(int $id, Request $request)
    {
        if (Auth::check()) {
            $transaction = Transaction::findOrFail($id);

            if ($transaction->commande->id_user === Auth::id()) {
                $transaction->article_non_recu()->delete();
                $transaction->photo_livraison()->delete();

                $transaction->delete();

                return redirect('/panier')->with('succes', 'Transaction annulé');
            } else {
                return redirect('/panier')->with('error', 'Acces a une transaction non autorisé');
            }
        } else {
            $panier = json_decode($request->cookie('panier', []), true);
            unset($panier[$id]);

            $biscuit = cookie('panier', json_encode($panier), 60 * 24 * 30);

            return redirect('/panier')->withCookie($biscuit);
        }
    }

    /**
     * Modifie la quantité d'article dans la transaction
     */
    public function updatequantite(Request $request, transaction $transaction)
    {
        if (Auth::check()) {
            $transaction->setAttribute('quantite', $request->input('quantite'));
            return response()->json('Quantité changé avec succès', 200);
        } else {
            $biscuit = $request->cookie('panier');
            $biscuit[$request->input('id_article')]['quantite'] = $request->input('quantite');
            return response('quantite updaté')->cookie($biscuit);
        }
    }
}
