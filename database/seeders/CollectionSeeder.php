<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Collection;
use App\Models\Article;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the Featured Collection with 'en vedette' articles
        $featuredCollection = Collection::create(['collection' => 'En Vedette']);
        $featuredArticles = Article::where('is_en_vedette', true) // Select articles that are featured
            ->inRandomOrder()
            ->take(20)
            ->pluck('id_article');
        $featuredCollection->articles()->attach($featuredArticles);

        // Create the New Collection with the most recent articles
        $newCollection = Collection::create(['collection' => 'Nouveautés']);
        $newArticles = Article::orderBy('created_at', 'desc') // Select the most recent articles
            ->take(20)
            ->pluck('id_article');
        $newCollection->articles()->attach($newArticles);

        // Create the Random Collection with random articles
        $randomCollection = Collection::create(['collection' => 'Au hasard']);
        $randomArticles = Article::inRandomOrder()
            ->take(20)
            ->pluck('id_article');
        $randomCollection->articles()->attach($randomArticles);
    }
}
