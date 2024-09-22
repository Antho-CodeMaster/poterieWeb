<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Commande;
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
    public function show(commande $commande)
    {
        //
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
     * for now, ONLY connected User
     */
    public function getPanier(Request $request){
        #returns the panier of the connected user
        if (Auth::check())
            return Commande::where('id_user', '=', Auth::id())->where('is_panier', '=', true)->firstOrCreate(['is_panier' => true]);
        else
            return $request->cookie('panier');

    }

    /**
     * Montre le panier et les articles contenu
     */
    public function showPanier(Request $request){

        #Montre le panier du user connecté
        if(Auth::check()){
            $commande = $this->getPanier($request);

            $articles = $commande->transactions->article->get();

            return view('commande/panier',
                ['commande' => $commande,
                        'articles' => $articles]
            );
            #$articles = Transaction::with('article')->where('id_commande', '=', $commande->id_commande);
            #$commande = Commande::with('transactions'.'article')->where('id_user', '=', Auth::id())->where('is_panier', '=', true)->firstOrCreate(['is_panier' => true]);
        }
    }


}
