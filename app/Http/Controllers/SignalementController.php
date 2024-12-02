<?php

namespace App\Http\Controllers;

use App\Models\Signalement;
use App\Models\Article;
use App\Models\Notification;
use Illuminate\Http\Request;

class SignalementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $signalements = Signalement::where('actif', true);
        $count = $signalements->count();
        $signalements = $signalements->skip(50 * ($page - 1))
            ->take(50)
            ->get();

        return view(
            'admin/signalements',
            [
                'signalements' => $signalements,
                'page' => $page - 1,
                'count' => $count,
                'total_pages' => ceil($count / 50),
            ]
        );
    }

    public function index_traites(Request $request)
    {
        $page = $request->input('page', 1);

        $signalements = Signalement::where('actif', false)->orderBy('updated_at', 'desc');
        $count = $signalements->count();
        $signalements = $signalements->skip(50 * ($page - 1))
            ->take(50)
            ->get();

        return view(
            'admin/signalements-traites',
            [
                'signalements' => $signalements,
                'page' => $page - 1,
                'count' => $count,
                'total_pages' => ceil($count / 50),
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Signalement $signalement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Signalement $signalement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Signalement $signalement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->input("id");

        $signalement = Signalement::find($id);

        if ($signalement) {
            $signalement->actif = 0;

            if (!$signalement->save()) {
                session()->flash('erreur', 'Un problème est survenu lors de la suppression du signalement.');
                return back();
            }
        }


        $idArticle = $request->input("id_article");
        if ($idArticle != null) {
            /* 1. Récupérer l'article en BD */
            $article = Article::where("id_article", $idArticle)->first();

            /* 2. Changer l'état (masqué aux clients et à l'artiste) */
            $article->id_etat = 3;

            /* 3. Mettre à jour l'article en BD */
            if ($article->save()) {
                session()->flash('succes', 'Article supprimé.');

                $notif = Notification::create([
                    'id_type' => 9,
                    'id_user' => $article->artiste->id_user,
                    'date' => now(),
                    'message' => $article->nom,
                    'lien' => route('kiosque', ['idUser' => $article->artiste->id_user]),
                    'visible' => 1
                ]);

                $notif->save();
            } else {
                session()->flash('erreur', 'Un problème est survenu lors de la suppression de l\'article.');
                if($signalement != null)
                {
                    $signalement->actif = 1;
                    $signalement->save();
                }
            }
        } else {
            session()->flash('succes', 'Signalement supprimé.');
        }

        return back();
    }
}
