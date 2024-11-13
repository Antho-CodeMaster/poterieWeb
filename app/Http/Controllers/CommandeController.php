<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Commande;
use App\Models\Artiste;
use App\Models\Notification;
use App\Models\Ville;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Laravel\Cashier\Invoice;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Transfer;
use Barryvdh\DomPDF\Facade\Pdf;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::check()){
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            $commandes = Commande::where('id_user', Auth::id())
            ->where('is_panier', false)
            ->get();

            $commandeEnCours = [];
            $commandeFini = [];

            foreach ($commandes as $commande) {
                if(isset($commande->payment_intent_id))
                {
                    $paymentIntent = PaymentIntent::retrieve($commande->payment_intent_id);
                    $charge = \Stripe\Charge::retrieve($paymentIntent->latest_charge);
                    $commande->receipt_url = $charge->receipt_url;
                }


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
    public function update(Request $request)
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
        Stripe::setApiKey(config('services.stripe.secret'));


        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],//paiement par carte
            'payment_intent_data' => [
                'transfer_group' => $commande->id_commande,  //met l'id de commande dans le transfer groupe pour transferer l'argent aux artistes
            ],
            'line_items' => $cartItems, // les items de la transaction
            'mode' => 'payment', // Paiement unique
            'shipping_address_collection' => [ //les pays accepté pour la livraison
                'allowed_countries' => ['CA']
            ],
            'success_url' => route('checkout-success').'?session_id={CHECKOUT_SESSION_ID}', //l'url a visiter en cas de succes
            'cancel_url' => route('panier'),    //idem mais en cas d'échec.
            'customer_email' => Auth::user()->email,
            'invoice_creation' => ['enabled'=>true], //permet de générer une facture avec stripe
            'automatic_tax' => ['enabled' => true], //permet de calculer les taxes, doit être setté dans le stripe dashboard
            'shipping_options' => [['shipping_rate_data' => [   //frais de livraisons
                    'display_name' => 'Frais de livraison',
                    'fixed_amount' => ['amount' => 1000, 'currency' => 'cad'],
                    'type' => 'fixed_amount'
                ]]
            ],
            'metadata' => ['id_commande' => $commande->id_commande],
        ]);

        $commande->update([
            'checkout_id' =>$checkoutSession->id,
        ]);


        return redirect($checkoutSession->url);
    }

    public function success(Request $request){


        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $sessionId = $request->input('session_id');
     #   echo $sessionId . '\n';
        $checkoutSession = Session::retrieve($sessionId); #$request->user()->stripe()->checkout->sessions->retrieve($request->get('session_id'));
     #  echo $checkoutSession;
        $paymentIntent = PaymentIntent::retrieve($checkoutSession->payment_intent);
    #    echo $paymentIntent;
        $charge = \Stripe\Charge::retrieve($paymentIntent->latest_charge);


        $commande = Commande::where('checkout_id', '=',$sessionId)->first();

        //On recupere les infos de shipping
        $addressLine = $paymentIntent->shipping->address->line1 ;
        $addressLine = str_replace(',', ' ', $addressLine);
        preg_match('/^(\d+)\s+(.*)$/', $addressLine, $matches);

        $noCivique = $matches[1] ?? null;
        $rue = $matches[2] ?? $addressLine;
        $codePostal = str_replace(' ', '', $paymentIntent->shipping->address->postal_code);
        $ville = Ville::firstOrCreate(['ville'=> $paymentIntent->shipping->address->city]);

        $commande->update([
            'is_panier' => false,
            'no_civique' => $noCivique,
            'rue' => $rue,
            'id_ville' => $ville->id_ville ,
            'code_postal' => $codePostal,
            'payment_intent_id' => $paymentIntent->id,
            'date' => now()
        ]);

        //Envoi des reçus

        $urlFacture = $charge->receipt_url;

        //Notifiactions
        //Client
        Notification::firstOrCreate([
            'lien' => '/commande/'.$commande->id_commande,
            'id_user' => Auth::id()
        ],[
            'message' => 'cliquez ici ou visitez la section "mes commandes".',
            'date' => now(),
            'id_type' => 6,
            'visible' => true
        ]);

        //Artiste
        foreach($commande->transactions as $transaction){
            Notification::firstOrCreate([
                'lien' => '/mesTransactions/'.$transaction->article->id_artiste,
                'message' => 'Vous avez des nouvelles transactions à traiter en lien avec la commande no:'.$commande->id_commande,
                'id_user' => $transaction->article->artiste->id_user
            ],[
                'date' => now(),
                'id_type' => 6,
                'visible' => true
            ]);
        }



        return view('commande.success',['commande' => $commande, 'facture'=>$urlFacture]);
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


    public function payerArtistes(Commande $commande){
        $transactions = Transaction::where('id_commande',$commande->id_commande)->groupBy('id_artiste')->get();
        foreach($transactions as $transaction){
            Transfer::create([
                'amount' => $transaction->prix_unitaire * $transaction->quantite,
                'currency' => 'cad',
                'source_transaction' => $commande->id_commande,
                'destination' => $transaction->article->artiste->user->stripe_id
            ]);

            Notification::firstOrCreate([
                'lien' => '/mesTransactions/'.$transaction->id_artiste,
                'message' => 'Vous avez des nouvelles transactions à traiter en lien avec la commande no:'.$commande->id_commande,
                'id_user' => $transaction->artiste->id_user
            ],[
                'date' => now(),
                'id_type' => 6,
                'visible' => true
            ]);
        }
    }

   /* public function recusArtistes(Session $session, Commande $commande){

        $lineItems = Session::allLineItems($session->id);
        echo "<br>". "<br>". "<br>". "<br>". "<br>". 'line Items : ' . $lineItems;

        $itemsByArtist = [];
        foreach ($commande->transactions as $transaction) {
            $artistId = $transaction->article->artiste->id_artiste;
            if ($artistId) {
                $itemsByArtist[$artistId][] = $transaction;
            }
        }


        foreach ($itemsByArtist as $artistId => $transactions) {

            $stripeAcc = $transaction->article->artiste->stripe_acc;
            foreach ($transactions as $transaction) {
                \Stripe\InvoiceItem::create([
                    'customer' => $session->customer,
                    'amount' => $transaction->prix_unitaire * $transaction->quantite * 100,
                    'currency' => $session->currency,
                    'description' => $transaction->article->nom,
                ]);
            }

            $invoice = \Stripe\Invoice::create([
                'customer' => $session->customer,
                'on_behalf_of' => $stripeAcc,
                'transfer_data' => ['destination' => $stripeAcc],
                'metadata' => ['artist_id' => $artistId, 'session_id' => $session->id, 'id_commande' => $commande->id_commande],
            ]);


            $invoice->finalizeInvoice();
            echo "<br>" . 'invoice : ' .$invoice;
        }
    }*/

    public function recusArtistes(int $id_commande){
        $artiste = Artiste::where('id_user',Auth::id())->first();
        $commande = Commande::where('id_commande',$id_commande)->first();

        $itemsByArtist = [];
        foreach ($commande->transactions as $transaction) {
            $artistId = $transaction->article->artiste->id_artiste;

            if ($artistId) {
                $itemsByArtist[$artistId][] = $transaction;
            }
        }

        if(array_key_exists($artiste->id_artiste,$itemsByArtist)){
            $data = [
                'date' => now()->format('Y-m-d'),
                'nom_artiste' => $artiste->nom_artiste,
                'id_artiste' => $artiste->id_artiste,
                'transaction_date' => $commande->created_at->format('Y-m-d'),
                'id_commande' => $commande->id_commande,
                'stripe_session_id' => $commande->checkout_id,
                'transactions' => $commande->transactions
            ];


            $pdf = Pdf::loadView('recus/recus_template', $data);
            return $pdf->stream('artiste_recus.pdf');
        }

    }

}
