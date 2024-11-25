<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Article;

class CollectionController extends Controller
{
    // Display collections on découverte
    public function index()
    {
        // Cache and load all collections
        $collections = Cache::remember('allCollections', 60, function () {
            return Collection::with('articles')->get();
        });
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
