<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
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
    public function show(article $article)
    {
        //
    }

    /**
     * Display the searched articles.
     */
    public function getSearch(Request $request)
    {
        // Retrieve the search term from the request
        $searchTerm = $request->input('search');

        // Query the articles table to find partial matches in the 'nom' and 'description' fields
        $articles = Article::where(function ($query) use ($searchTerm) {
            $query->where('nom', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhereHas('motCles', function ($subQuery) use ($searchTerm) {
                      $subQuery->where('mot_cle', 'LIKE', '%' . $searchTerm . '%');
                  });
            })
            ->where('id_etat', 1)
            ->get();

        // Return the results to the view with the search term and matched articles
        return view('recherche.recherche', compact('articles', 'searchTerm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(article $article)
    {
        //
    }
}
