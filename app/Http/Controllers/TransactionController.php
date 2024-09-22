<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Commande;
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
     */
    public function store(Request $request)
    {
        #Créé une entrée transaction pour l'utilisateur connecté
        if(Auth::check()){
            Transaction::create([
                'id_commande' => $request->input('id_commande'),
                'id_user' => Auth::id(),
                'quantite' => 1
            ]);

            return response()->json(['message'=>'Article ajouté a la commande avec succes'], 200);
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
     * Update la quantité d'article dans la transaction
     */
    public function update(Request $request, transaction $transaction)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaction $transaction)
    {
        //
    }

    /**
     * Modifie la quantité d'article dans la transaction
     */
    public function updatequantite(Request $request, transaction $transaction){
        if(Auth::check()){
            $transaction->setAttribute('quantite', $request->input('quantite'));
        }
    }
}
