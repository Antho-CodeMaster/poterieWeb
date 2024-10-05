<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Photo_oeuvre;
use App\Models\Photo_identite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/demandes', ['demandes' => Demande::with('photos_oeuvres')->with('photos_identite')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('devenir-artiste');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nomType = $request->input('type');
        if ($nomType == "etu")
            $type = 2;
        else if ($nomType == "pro")
            $type = 3;
        else
            return back()->withErrors(['msg' => 'Une erreur inattendue est survenue. Veuillez réessayer.']);

        // Validation de base
        $rules = [ "photo-preuve" => "required|array|between:1,5" ];

        // Valider qu'il y a bel et bien 3 photos si la demande est pour un étudiant
        if ($type == 2)
            $rules['photo-identite'] = 'required|array|size:3';

        // Performer la validation
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        // Stockage de la demande

        $newDemande = Demande::create([
            'id_type' => $type,
            'id_etat' => 1, // En attente
            'id_user' => Auth::id(),
            'date' => now()
        ]);
        $newDemande->save();
        $id_demande = $newDemande->id_demande;

        // Stockage des photos d'identité, seulement si l'utilisateur sera étudiant / renouvellement étudiant

        $files = $request->file('photo-identite');

        if ($request->hasFile('photo-identite')  && $type != 3) {
            foreach ($files as $file) {
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('tests', $filename, 'public');
                $newPhoto = new Photo_identite();
                $newPhoto->id_demande = $id_demande;
                $newPhoto->path = $filePath;
                $newPhoto->save();
            }
        }

        // Stockage des photos d'oeuvre

        $files = $request->file('photo-preuve');

        if ($request->hasFile('photo-preuve')) {
            foreach ($files as $file) {
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('tests', $filename, 'public');
                $newPhoto = new Photo_oeuvre();
                $newPhoto->id_demande = $id_demande;
                $newPhoto->path = $filePath;
                $newPhoto->save();
            }
        }

        return redirect()->route('decouverte');
    }

    /**
     * Display the specified resource.
     */
    public function show(demande $demande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(demande $demande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, demande $demande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(demande $demande)
    {
        //
    }
}
