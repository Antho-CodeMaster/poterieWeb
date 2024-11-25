<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;
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

    // Show form to create a new collection
    public function create()
    {
        $articles = Article::all();
        return view('collections.create', compact('articles'));
    }

    // Store a new collection
    public function store(Request $request)
    {
        $request->validate([
            'collection' => 'required|string|max:255',
            'articles' => 'required|array', // expect an array of article IDs
        ]);

        // Create the collection
        $collection = Collection::create([
            'collection' => $request->input('collection'),
        ]);

        // Sync the articles with the collection
        $collection->articles()->sync($request->input('articles'));

        return redirect()->route('collections.index')->with('success', 'Collection created successfully!');
    }

    // Show a specific collection
    public function show($id)
    {
        $collection = Collection::with('articles')->findOrFail($id);
        return view('collections.show', compact('collection'));
    }
}
