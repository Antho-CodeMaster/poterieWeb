<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Commande;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            Transaction::create([
                'id_commande' => $request->input('id_commande'),
                'id_user' => Auth::id(),
                'id_article' => $request->input('id_article'),
                'quantite' => 1
            ]);

            return response()->json(['message'=>'Article ajouté a la commande avec succes'], 200);
        }
        #Créé un cookie qui store le panier si l'utilisateur n'est pas connecté
        else{
            #récupère le cookie déja existant (sinon on en créé un vide)
            $panier = $request->cookie('panier',[]);

            $id_article = $request->input('id_article');

            $panier[$id_article] = [
                'id_article' => $id_article,
                'quantite' => 1
            ];


            #Update le cookie pour un 30j d'activité après avoir ajouté un article
            $biscuit = cookie('panier',$panier, 60*24*30);

            return response('Article ajouté au panier (biscuit)')->cookie($biscuit);
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
    public function update(Request $request, transaction $transaction)
    {

    }

    /**
     * Remove the specified resource from storage.
     * works for connected users
     */
    public function destroy(transaction $transaction, Request $request)
    {
        try{
            if (Auth::check()){
                $transaction->delete();
                return response()->json(['message' => 'Transaction effacé avec succès'],200);
            }
        }catch(Exception $e){
            return response()->json(['message' => $e], 400);
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
