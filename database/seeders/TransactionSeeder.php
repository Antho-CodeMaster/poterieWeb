<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Article;

class TransactionSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés.
     */
    public function run(): void
    {
        // Pour chaque commande
        for($i = 1; $i <= 10; $i++)
            // Générer entre 1 et 10 transactions
            for($j = 0; $j <= random_int(1, 10); $j++)
            {
                $etat = random_int(1, 5);
                $id_article = random_int(1, 50);
                $article = Article::where('id_article', $id_article)->get();

                DB::table('transactions')->insert([
                    'id_commande' => $i,
                    'id_article' => 3,
                    'id_etat' => random_int(1, 5),
                    'id_compagnie' => random_int(1, 3),
                    'quantite' => $article->unique ? 1 : random_int(1, $article->quantite_disponible),
                    'prix_unitaire' => fake()->randomFloat(2, 1, 9999),
                    'date_reception_prevue' => now(),
                    'date_reception_effective' => $etat == 3 ? now() : null,
                ]);
            }
        //Générer transactions prédéfinies pour tests
        for($i = 0; $i <= 5; $i++)
        {
            $id_article = random_int(1, 50);
            $article = Article::where('id_article', $id_article)->get();

            DB::table('transactions')->insert([
                'id_commande' => 31,
                'id_article' => $id_article,
                'id_etat' => 4,
                'id_compagnie' => random_int(1, 3),
                'quantite' => $article->unique ? 1 : random_int(1, $article->quantite_disponible),
                'prix_unitaire' => fake()->randomFloat(2, 1, 999),
                'date_reception_prevue' => now(),
                'date_reception_effective' => $etat == 3 ? now() : null,
            ]);

            DB::table('transactions')->insert([
                'id_commande' => 32,
                'id_article' => $id_article,
                'id_etat' => rand(2,5),
                'id_compagnie' => random_int(1, 3),
                'quantite' => $article->unique ? 1 : random_int(1, $article->quantite_disponible),
                'prix_unitaire' => fake()->randomFloat(2, 1, 999),
                'date_reception_prevue' => now(),
                'date_reception_effective' => $etat == 3 ? now() : null,
            ]);
        }
    }

}
