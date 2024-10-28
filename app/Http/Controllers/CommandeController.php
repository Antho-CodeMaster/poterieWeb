<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Commande;
use App\Models\Artiste;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::check()){
            $commandes = Commande::where('id_user', Auth::id())
            ->where('is_panier', false)
            ->get();

            $commandeEnCours = [];
            $commandeFini = [];

            foreach ($commandes as $commande) {
                $hasActiveTransaction = false;
                foreach ($commande->transactions as $transaction) {
                    $etat = $transaction->etat_transaction->etat;
                    if ($etat === 'En cours' || $etat === 'Traité') {
                        $hasActiveTransaction = true;
                        break;
                    }
                }
                if ($hasActiveTransaction) {
                    $commandeEnCours[] = $commande;
                } else {
                    $commandeFini[] = $commande;
                }
            }

            return view('commande/commandes',[
                'commandes' => $commandes,
                'commandeEnCours' => $commandeEnCours,
                'commandeFini' => $commandeFini
            ]);
        }
        else{
            return view('commande/commandes', ['commandes' => null, 'authis' => Auth::id()]);
        }

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
    public function show(int $id_commande)
    {

        $commande = Commande::where('id_commande', $id_commande)->first();

        //if(Artiste::where('id_artiste' , Auth::id()) != $commande->id_user || )
        $articleParArtiste = $commande->transactions->groupBy(function ($transaction){
            return $transaction->article->artiste;
        });
        return view('commande.commande-detail', ['commande' => $commande, 'articleParArtiste' => $articleParArtiste]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(commande $commande)
    {
        //
    }

    /**
     * Get the panier if it exists or create an empty one
     * Same for disconnected users
     */
    public function getPanier(Request $request){
        # returns the panier of the connected user
        # or the disconnected user
        if (Auth::check())
            return Commande::firstOrCreate(
                ['id_user' => Auth::id(), 'is_panier' => true]
            );
        else{
            //recupere les cookies
            $cookie = $request->cookie('panier','');
            $items = $cookie ? json_decode($cookie,true) : [];

            //cree pbj commande
            $commande = new Commande();
            $commande->transactions->collect();

            foreach($items as $item){
                $article = Article::find($item['id_article']);
                if($article){
                    $transaction = new Transaction();
                    $transaction->article = $article;
                    $transaction->quantite = $item['quantite'];
                    $transaction->prix_unitaire = $article->prix;
                    $transaction->id_transaction = $item['id_article'];

                    $commande->transactions->push($transaction);
                }
            }
            return $commande;
        }

    }

    /**
     * Montre le panier et les articles contenu
     */
    public function showPanier(Request $request){

        #Prend les valeurs dans la bd si connecté ou dans le cookie si non connecté
        if(Auth::check()){
            $commande = $this->getPanier($request);
        }
        else{
            $commande = $this->getPanier($request);
        }

        return view( 'commande/panier',
                ['commande' => $commande]);
    }


    /**Gestion de Checkout */

    public function checkoutCommande(Request $request){

        $commande = $this->getPanier($request);

        #On formate les transactions du panier en Items lisible pour Stripe Checkout
        $cartItems = $this->FormatPanier($commande);


        #Set de la clé d'api pour stripe
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $checkoutSession = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $cartItems,
            'mode' => 'payment', // Paiement unique
            'success_url' => route('checkout-success'),
            'cancel_url' => route('checkout-cancel'),
        ]);

        $commande->update(['checkout_session_id' => $checkoutSession->id]);

        return redirect($checkoutSession->url);
    }

    public function success(){

    }
    public function cancel(){

    }

    public function FormatPanier(Commande $panier){
        $items =[];
        foreach($panier->transactions as $transaction){

            $item = [
                'price_data' => [
                    'currency' => 'cad',
                    'product_data' => [
                        'name' => $transaction->article->nom,
                    ],
                    'unit_amount' => $transaction->prix_unitaire * 100, // Prix en cenne (Prix en dollards * 100)
                ],
                'quantity' => $transaction->quantite,
            ];

            /**Ajoute l'item a l'array */
            array_push($items, $item);
        }

        return $items;
    }

}
