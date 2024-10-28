<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Commande;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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
        if(Auth::check()){
            //Get le panier ou on le créé
            $commande = Commande::firstOrCreate(
                ['id_user' => Auth::id(), 'is_panier' => true]
            );

            //get si la transaction existe deja ou en créé une nouvelle
            $transaction = Transaction::firstOrCreate([
                'id_commande' => $commande->id_commande,
                'id_article' => $request->input('id_article')],
                ['quantite' => 1,'id_etat' => 2]);

            #
            $transaction->update(['prix_unitaire' => $transaction->article->prix]);

            return Redirect::back(302,['message' => 'Succes: Article ajouté au panier']);
        }
        #Créé un cookie qui store le panier si l'utilisateur n'est pas connecté
        else{
            #récupère le cookie déja existant (sinon on en créé un vide)
            $panier = json_decode($request->cookie('panier',''),true);

            $id_article = $request->input('id_article');

            $panier[$id_article] = [
                'id_article' => $id_article,
                'quantite' => 1
            ];


            #Update le cookie pour un 30j d'activité après avoir ajouté un article
            $biscuit = cookie('panier',json_encode($panier), 60*24*30);

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
    public function edit(transaction $transaction)
    {
        //
    }

    /**
     * Update rien pour l'instant
     */
    public function update(Request $request)
    {
        if(Auth::check()){

        }
    }

    /**
     * Remove the specified resource from storage.
     * works for connected users
     */

    public function destroy(int $id, Request $request)
    {
        if (Auth::check()){
            $transaction = Transaction::findOrFail($id);

            if($transaction->commande->id_user === Auth::id()){
                $transaction->article_non_recu()->delete();
                $transaction->photo_livraison()->delete();

                $transaction->delete();

                return redirect('/panier')->with('succes', 'Transaction annulé');
            }else{
                return redirect('/panier')->with('error', 'Acces a une transaction non autorisé');
            }
        }
        else{
            $panier = json_decode($request->cookie('panier',[]),true);
            unset($panier[$id]);

            $biscuit = cookie('panier',json_encode($panier), 60*24*30);

            return redirect('/panier')->withCookie($biscuit);
        }

    }

    /**
     * Modifie la quantité d'article dans la transaction
     */
    public function updatequantite(Request $request, transaction $transaction){
        if(Auth::check()){
            $transaction->setAttribute('quantite', $request->input('quantite'));
            return response()->json('Quantité changé avec succès',200);
        }
        else{
            $biscuit = $request->cookie('panier');
            $biscuit[$request->input('id_article')]['quantite'] = $request->input('quantite');
            return response('quantite updaté')->cookie($biscuit);
        }
    }
}
