<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Article;
use App\Models\Signalement;
use App\Models\Demande;
use App\Models\Article_non_recu;
use App\Models\Transaction;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/dashboard', [
            'utilisateurs' => User::All()->count(),
            'articles' => Article::All()->count(),
            'signalements' => Signalement::All()->count(),
            'demandes' => Demande::All()->count(),
            'newDemandes' => Demande::where('id_etat', 1)->count(),
            'articles_non_recus' => Article_non_recu::All()->count(),
            'transactions' => Transaction::All()->count()
        ]);

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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
