<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhotoOeuvreSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés.
     */
    public function run(): void
    {
        // Pour chacune des demandes de nouvel utilisateur
        for($i = 1; $i <= 53; $i++)
        {
            // Les articles, dans cette mise en situation, auront entre 1 et 10 photos chacun
            for($j = 1; $j <= random_int(1, 10); $j++)

            /* Les paths des photos bidon sont:
                public/img/tests/pot_1.jpg,
                public/img/tests/pot_2.jpg,
                public/img/tests/pot_3.jpg,
                public/img/tests/pot_4.jpg,
                d'où la concaténation du path avec la variable $j.
            */
            DB::table('photos_oeuvres')->insert([
                'id_demande' => $i,
                'path' => 'pot_' . random_int(1, 14) . '.jpg',
            ]);
        }
    }
}
