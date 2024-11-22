<?php

namespace App\Http\Controllers;

use App\Models\Article_non_recu;
use App\Models\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArticleNonRecuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'admin/articles-non-recus',
            [
                'anrs' => Article_non_recu::All(),
            ]
        );
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
        /* Validation des entrées */
        $validatedData = $request->validate([
            "id_transaction" => "required",
            "signaleDescription" => "required|max:255",
        ], [
            "signaleDescription.required" => "La description du signalement est obligatoire.",
            "signaleDescription.max" => "La description du signalement ne peut pas dépasser 255 caractères.",
        ]);

        /* Validation que la commande a été passée il y a au moins un mois */
        $transaction = Transaction::where('id_transaction', $validatedData["id_transaction"])->first();

        if($transaction->id_etat != 5)
            if(now() < Carbon::create($transaction->created_at)->addMonth())
            {
                session()->flash('erreur', 'Vous devez attendre au moins un mois après la commande pour signaler un article comme non reçu.');
                return back();
            }

        /* Validation que l'article n'a pas déjà été signalé */
        $anr = Article_non_recu::where('id_transaction', $validatedData["id_transaction"])->first();
        if($anr != null)
        {
            session()->flash('erreur', 'Vous avez déjà signalé cet article comme non reçu. Veuillez attendre le verdict de l\'administration.');
            return back();
        }

        $newsignalement = Article_non_recu::create([
            "id_transaction" => $validatedData["id_transaction"],
            "description" => $validatedData["signaleDescription"]
        ]);

        /* Stockage en BD du nouvel article */
        if ($newsignalement->save()) {
            session()->flash('succes', 'Le signalement a été envoyé. Nous vous recontacterons sous peu par courriel!');
        } else {
            session()->flash('erreur', 'Un problème lors du signalement de l\'article s\'est produit.');
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Article_non_recu $article_non_recu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article_non_recu $article_non_recu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article_non_recu $article_non_recu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->input("id");

        $anr = Article_non_recu::where('id_signalement', $id)->first();

        session()->flash('succes', 'Demande supprimée.');

        $notif = Notification::create([
            'id_type' => 10,
            'id_user' => $anr->transaction->commande->id_user,
            'date' => now(),
            'message' => '',
            'lien' => route('contact'),
            'visible' => 1
        ]);

        $notif->save();

        Article_non_recu::destroy($id);

        return back();
    }
}
