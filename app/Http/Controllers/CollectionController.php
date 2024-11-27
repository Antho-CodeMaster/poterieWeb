<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Article;

class CollectionController extends Controller
{
    // Display collections on découverte
    public function index()
    {
        // Generate "En vedette" collection (e.g., based on featured articles)
        $enVedette = Article::where('is_en_vedette', 1)->take(20)->get();

        // Generate "Nouveautés" collection (e.g., newest articles)
        $nouveautes = Article::orderBy('created_at', 'desc')->take(20)->get();

        // Generate "Au hasard" collection (e.g., random selection of articles)
        $auHasard = Article::inRandomOrder()->take(20)->get();

        // Generate "Vos articles aimés" collection (e.g., articles liked by the logged-in user)
        $vosArticlesAimes = Auth::check()
            ? Article::whereHas('likes', function ($query) {
                $query->where('id_user', Auth::id());
            })->get()
            : collect(); // Empty collection if the user is not logged in

        // Pass collections to the view
        $collections = [
            'En vedette' => $enVedette,
            'Nouveautés' => $nouveautes,
            'Découvrez' => $auHasard,
            'Vos articles aimés' => $vosArticlesAimes,
        ];

        // Return the collections object to the view
        return view('decouverte', compact('collections'));
    }
}
