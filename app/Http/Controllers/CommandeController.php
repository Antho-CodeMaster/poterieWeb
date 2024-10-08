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
        else
            return $request->cookie('panier', []);
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

            $articles = [];
            foreach($commande as $id_article){
                $articles[] = Article::where('id_article', '=', $id_article)->first();
            }

        }

        return view( 'commande/panier',
                ['commande' => $commande]);
    }


}
