<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhotoLivraisonSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés.
     */
    public function run(): void
    {
        // Pour chacune des transactions
        for($i = 1; $i <= DB::table('transactions')->count(); $i++)
        {
            // Les demandes, dans cette mise en situation, auront une ou deux photos de livraison
            for($j = 1; $j <= random_int(1, 2); $j++)

            /* Les paths des photos bidon sont:
                public/img/tests/photo_livraison_1.jpg,
                public/img/tests/photo_livraison_2.jpg,
                d'où la concaténation du path avec la variable $j.
            */
            DB::table('photos_livraison')->insert([
                'id_transaction' => $i,
                'path' => 'tests/photo_livraison_' . $j . '.jpg',
            ]);
        }
    }
}
