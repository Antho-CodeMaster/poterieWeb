<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use App\Models\Moderateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/utilisateurs',
        [
            'users' => User::where('active', 1)->get(),
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Update the user's accessibility (blur) information.
     */
    public function updateUnits(Request $request)
    {
        /* 1. Récupérer la valeur */
        $units = $request->input("units");

        /* 2. Récupérer l'utilisateur à qui cela s'addresse */
        $user = User::where("id", Auth::id());

        /* 5. Update de l'article*/
        if ($user->update([
            "units" => $units
        ])) {
            session()->flash('succesUnits', 'L\'unité a bien été modifiée');
        } else {
            session()->flash('erreurUnits', 'Un problème lors de la mise à jour de l\'unité s\'est produit');

            /* Retour à la vue */
            return redirect()->route('profile.edit');
        }

        return redirect()->route('profile.edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $id = request()->query('id');
        $user = User::where('id', $id)->first();
        $user->active = 0;
        $user->save();
        return redirect()->to(route('admin-utilisateurs'));
    }

    public function avertir()
    {
        $id = request()->query('id');
        $notif = Notification::create([
            'id_type' => 1,
            'id_user' => $id,
            'date' => now(),
            'message' => request()->input('reason'),
            'lien' => null,
            'visible' => 1
        ]);
        $notif->save();
        return redirect()->to(route('admin-utilisateurs'));
    }

    // Créer une nouvelle instance de modérateur ou rendre administrateur un modérateur
    public function promote()
    {
        $id = request()->query('id');
        $mod = Moderateur::where([
            'id_user' => $id,
        ])->first();

        if ($mod == null)
            $mod = Moderateur::create([
                'id_user' => $id,
                'is_admin' => 0
            ]);
        else
            $mod->is_admin = 1;

        $mod->save();
        return redirect()->to(route('admin-utilisateurs'));
    }

    // Supprimer une instance de modérateur ou rendre modérateur un administrateur

    public function demote()
    {
        $id = request()->query('id');
        $mod = Moderateur::where([
            'id_user' => $id,
        ])->first();

        if ($mod->is_admin == 1) {
            $mod->is_admin = 0;
            $mod->save();
        } else
            $mod->delete();
        return redirect()->to(route('admin-utilisateurs'));
    }
}
