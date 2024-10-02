<?php

namespace App\Http\Controllers;

use App\Models\Artiste;
use Illuminate\Http\Request;

class ArtisteController extends Controller
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(artiste $artiste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(artiste $artiste)
    {
        //
    }

        /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, artiste $artiste)
    {
        //
    }

    /**
     * Update the artist's profile picture and saves it to img/artistePFP.
     */
    public function updatePicture(Request $request, artiste $artiste)
    {
        // Validate the incoming request
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',  // Validate file type and size
        ]);

        // Check if an image was uploaded
        if ($request->hasFile('image')) {
            // Get the uploaded image
            $image = $request->file('image');

            // Generate a unique name for the image file
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Save the image in the public/img/artistePFP directory
            $image->move(public_path('img/artistePFP'), $imageName);

            // Update the artiste's path_photo_profil field with the new image path
            $artiste->path_photo_profil = 'img/artistePFP/' . $imageName;
        }

        // Save any other updates (you can add other fields you want to update here)
        $artiste->save();

        // Redirect back with a success message
        return redirect()->route('profile.edit')
            ->with('status', 'picture-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(artiste $artiste)
    {
        //
    }
}
