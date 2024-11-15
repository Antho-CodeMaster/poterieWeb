<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
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
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }

    /**
     * Allows adding and removing likes
     */
    public function toggleLike($articleId)
    {
        $user = auth()->user();

        // Check if the user has already liked this article
        $like = $user->likes()->where('id_article', $articleId)->first();

        if ($like) {
            // If the like exists, delete it
            Like::where('id_user', $user->id)->where('id_article', $articleId)->delete();
            return response()->json(['liked' => false]);  // Return the updated state
        } else {
            // If no like exists, create a new one
            $user->likes()->create([
                'id_article' => $articleId
            ]);
            return response()->json(['liked' => true]);  // Return the updated state
        }
    }
}
