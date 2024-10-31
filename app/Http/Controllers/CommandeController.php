<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Commande;
use App\Models\Artiste;
use App\Models\Ville;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;

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
        return view('commande.formInfos');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
            return $this->saveCookieToDb($request);
        else{
            return $this->cookieToCommande($request);
        }

    }

    /**
     * Montre le panier et les articles contenu
     */
    public function showPanier(Request $request){

        #Prend les valeurs dans la bd si connecté ou dans le cookie si non connecté
        $commande = $this->getPanier($request);

        if(Auth::check()){
            return response()->view('commande/panier',
                ['commande' => $commande])->withCookie(Cookie::forget('panier'));
        }
        else
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

        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $cartItems,
            'mode' => 'payment', // Paiement unique
            'shipping_address_collection' => [
                'allowed_countries' => ['CA']
            ],
            'success_url' => route('checkout-success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('panier'),
        ]);

        $commande->checkout_id = $checkoutSession->id;

        $commande->save();

        return redirect($checkoutSession->url);
    }

    public function success(Request $request){


        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $sessionId = $request->get('session_id');
        echo $sessionId . '\n';
        $checkoutSession = Session::retrieve($sessionId); #$request->user()->stripe()->checkout->sessions->retrieve($request->get('session_id'));
        echo $checkoutSession. '\n';
        $paymentIntent = PaymentIntent::retrieve($checkoutSession->payment_intent);
        echo $paymentIntent. '\n';

        $commande = Commande::where('checkout_id', $sessionId)->first();

        //On recupere les infos de shipping
        $addressLine = $paymentIntent->shipping->address->line1;
        preg_match('/^(\d+)\s+(.*)$/', $addressLine, $matches);

        $noCivique = $matches[1] ?? null;
        $rue = $matches[2] ?? $addressLine;
        $codePostal = str_replace(' ', '', $paymentIntent->shipping->address->postal_code);

        $ville = Ville::firstOrCreate(['ville'=>$paymentIntent->shipping->address->city]);

        $commande->update([
            'is_panier' => false,
            'no_civique' => $noCivique,
            'rue' => $rue,
            'ville' => $ville->id_ville ,
            'code_postal' => $codePostal,
            'payment_intent_id' => $paymentIntent->id
        ]);

        return view('commande.success',['commande' => $commande]);
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

    public function saveCookieToDb(Request $request){
        $commandeUnsaved = $this->cookieToCommande($request);

        $commande = Commande::firstOrCreate(
            ['id_user' => Auth::id(), 'is_panier' => true]
        );

        foreach($commandeUnsaved->transactions as $transaction){
            if(!$commande->transactions->contains('id_article',$transaction->id_article)){
                $commande->transactions()->save($transaction);
            }
        }

       $commande->save();

        return $commande;
    }

    public function cookieToCommande(Request $request){
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
                #$transaction->id_article = $article->id_article;
                $transaction->quantite = $item['quantite'];
                $transaction->prix_unitaire = $article->prix;
                $transaction->id_article = $item['id_article'];
                $transaction->id_etat = 2;

                $commande->transactions->push($transaction);
            }
        }

        return $commande;
    }

}
