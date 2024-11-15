<?php

namespace App\Http\Controllers;

use App\Models\Artiste;
use App\Models\Article;
use App\Models\Transaction;
use App\Models\Commande;
use App\Models\Compagnie_livraison;
use App\Models\Photo_livraison;
use App\Models\Photo_oeuvre;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Stripe\Invoice;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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
            // Compter les transactions non traitées dans chaque commande (id_etat 2 = en attente)
            return $transactions->where('id_etat', 2)->count();
        })->sortByDesc(function ($transactions) {
            // Puis trier par la date de commande (plus récente en premier)
            return $transactions->first()->commande->date; // Assurez-vous que `date` est bien une propriété de votre modèle
        });


        //Scrap that, trash code lmao i spent to much time on this for nooooone
        /* 5. Récupérer auprès de stripe les informations de facturations */
        /*\Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $stripeId = Artiste::where('id_user',$idUser)->pluck('stripe_acc')->first();

        $invoices = Invoice::all([],[
            'stripe_account' => $stripeId
        ]);

        $invoiceUrls = [];

        foreach($invoices->data as $invoice){
            if ($invoice->hosted_invoice_url) {
                $invoiceUrls[] = $invoice->hosted_invoice_url;
            } else {
                // If the hosted link is missing, send the invoice to generate the link
                $sentInvoice = Invoice::retrieve($invoice->id, [
                    'stripe_account' => $stripeId,
                ]);
                $sentInvoice->sendInvoice(); // This generates the hosted link
                $invoiceUrls[] = $sentInvoice->hosted_invoice_url;
            }
        }*/

        return view('commande.commandesArtiste', [
            'articles' => $articles,
            'commandeTransactions' => $commandeTransactions,
        ]);
    }


    /**
     * Fonction pour filtrer les transactions dans la commandes
     */
    public function commandesFiltre(Request $request)
    {
        // 1. Récupérer les valeurs des filtres envoyés depuis le client
        $dateFiltre = $request->input('dateFilter');
        $dateFiltre = $dateFiltre ?? '1'; //Pour filtrer en ordre croissant toujours si aucun filtre

        $compagnieFilter = $request->input('compagnieFilter');
        $statutFilter = $request->input('statutFilter');
        $searchTerm = $request->input('searchTransaction');

        // 2. Récupérer l'artiste connecté
        $artiste = Artiste::where('id_user', $request->input("idArtiste"))->first();

        /* 3. Récupérer les articles de l'artiste */
        $articles = Article::where('id_artiste', $artiste->id_artiste)->get();

        /* 3. Créer un array contenant que les id de chaque article */
        $articleIds = $articles->pluck('id_article')->toArray();

        // 4. Commencer la requête pour filtrer les commandes liées aux transactions
        $commandeTransactions = Transaction::whereIn('id_article', $articleIds)
            ->when(!empty($compagnieFilter) && $compagnieFilter !== 'null', function ($query) use ($compagnieFilter) {
                // Filtrer par compagnie si défini
                $query->where('id_compagnie', $compagnieFilter);
            })
            ->when(!empty($statutFilter) && $statutFilter !== 'null', function ($query) use ($statutFilter) {
                // Filtrer par statut si défini
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
            ->groupBy('id_commande') // Grouper par commande
            ->sortByDesc(function ($transactions) {
                // Trier pour afficher les commandes avec le plus de transactions en cours (`id_etat = 2`) en premier
                return $transactions->where('id_etat', 2)->count();
            })
            ->sortBy(function ($transactions) use ($dateFiltre) {
                // Trier par date de commande (croissant ou décroissant selon `dateFiltre`)
                $date = $transactions->first()->commande->date ?? null;
                return $dateFiltre === '0' ? $date : -strtotime($date);
            });

        try {
            $view = view('commande.partials.allTransactions', compact('commandeTransactions', 'artiste'))->render();
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
            'commandeTransactions' => $commandeTransactions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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
     * Display the specified resource.
     */
    public function show(transaction $transaction)
    {
        //
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

        return view("commande.traiterTransactionForm")->with("transaction", $transaction)->with("compagnies", $compagnies);
    }


    /**
     * Update rien pour l'instant
     */
    public function update(Request $request)
    {
        if (Auth::check()) {

            if ($request->routeIs('traiterTransaction')) {

                /* 1. Récupérer et valider les données du form */
                $validatedData = $request->validate([
                    "idTransaction" => "required",
                    "dateLivraison" => "required",
                    "compagnieLivraison" => "required",
                    "codeRefLivraison" => "required",
                    "photo1" => "required|mimes:jpeg,png,jpg",
                    "photo2" => "mimes:jpeg,png,jpg",
                ], [
                    "compagnieLivraison.required" => "Le numéro de tracking de la livraison est obligatoire.",
                    "codeRefLivraison.required" => "Le numéro de tracking de la livraison est obligatoire.",
                    "dateLivraison.required" => "La date de livraison prévue est obligatoire.",
                    'photo1.mimes' => 'La photo 1 doit être au format JPEG, PNG ou JPG.',
                    'photo1.required' => 'Il doit y avoir au moins 1 photo de livraison afin de traiter une transaction correctement',
                    'photo2.mimes' => 'La photo 2 doit être au format JPEG, PNG ou JPG.',
                ]);

                /* Gestion des photos de livraisons */
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
                        $newPhotoLivraison->id_transaction = $validatedData["idTransaction"];
                        $newPhotoLivraison->path = $filePath; // Stockage du chemin exact en base de données

                        if (!$newPhotoLivraison->save()) {
                            session()->flash('erreurPhotos', 'Un problème lors de l\'ajout des photos s\'est produit, veuillez réessayer.');
                            return back();
                        }
                    }
                }

                $transaction = Transaction::where("id_transaction", $validatedData["idTransaction"]);

                /* Gestion du numéro de tracking */
                /* 1. Récupérer la transaction à modifier */

                /* 2. Modifier le numéro de tracking*/
                if (!$transaction->update([
                    'code_ref_livraison' => $validatedData['codeRefLivraison'],
                ])) {
                    session()->flash('erreurCodeRefLivraison', 'Un problème lors de l\'ajout du numéro de suivis s\'est produit');
                    return back();
                }

                /* Modification de l'Étatde la transaction */
                if (!$transaction->update([
                    'id_etat' => 3,
                ])) {
                    session()->flash('erreurEtatTransaction', 'Un problème lors de la modification du statut de la transaction s\'est produit');
                    return back();
                }

                /* Gestion de la compagnie de livraison */
                if (!$transaction->update([
                    'id_compagnie' => $validatedData['compagnieLivraison'],
                ])) {
                    session()->flash('erreurCompagnieLivraison', 'Un problème lors de l\'ajout du numéro de suivis s\'est produit');
                    return back();
                }

                /* Gestion de la date de livraison de livraison */
                if (!$transaction->update([
                    'date_reception_prevue' => $validatedData['dateLivraison'],
                ])) {
                    session()->flash('erreurDateLivraison', 'Un problème lors de l\'ajout de la date de livraison s\'est produit');
                    return back();
                }

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
        $panierData = $request->input('cart')->json_decode();
        $qte = $request->input('quantite');


        if (Auth::check()) {
            try {

                foreach ($panierData as $item) {
                    $transaction = Transaction::first($item['Transaction']);

                    if ($qte > $transaction->article->quantite_disponible || $qte < 0) {
                        throw new Exception('Failed to update, Quantity out of bound');
                    }

                    $transaction->update([
                        'quantite' => $qte
                    ]);
                }
            } catch (Exception $e) {
                return response(400)->json()->withException($e);
            }
            return response()->json(['message' => 'Success, quantity data updated to ' . $transaction->quantite]);
        } else {

            $panier = json_decode($request->cookie('panier', ''), true);

            foreach ($panierData as $item) {
                try {
                    if ($qte > Article::firts($item['Article'])->quantite_disponible || $qte < 0) {
                        throw new Exception('Failed to update, Quantity out of bound');
                    }

                    $panier[$item['Article']]['quantite'] = $item['quantite'];
                } catch (Exception $e) {
                    return response(400)->json()->withException($e);
                }
            }

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
