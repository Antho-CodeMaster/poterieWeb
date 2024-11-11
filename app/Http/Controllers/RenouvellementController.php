<?php

namespace App\Http\Controllers;

use App\Models\Renouvellement;
use App\Models\Artiste;
use App\Models\Notification;
use App\Notifications\Demande_renouvellement;
use App\Models\User;
use Illuminate\Http\Request;

class RenouvellementController extends Controller
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

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $renouvellement = Renouvellement::create();
        $renouvellement->save();

        $artistes = Artiste::where([
            'is_etudiant' => 1,
        ])->get();

        foreach ($artistes as $artiste) {
            // Notifier user

            $notif = Notification::create([
                'id_type' => 4,
                'id_user' => $artiste->id_user,
                'date' => now(),
                'message' => '',
                'lien' => null,
                'visible' => 1
            ]);
            $notif->save();

            /* Aussi notifier par courriel. */

            $usr = User::find($artiste->id_user);
            $usr->notify(new Demande_renouvellement($artiste->id_user));
        }

        return redirect()->to(route('admin-display-renouvellement'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Renouvellement $renouvellement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Renouvellement $renouvellement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Renouvellement $renouvellement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Renouvellement $renouvellement)
    {
        //
    }
}
