<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhotoIdentiteSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés.
     */
    public function run(): void
    {
        // Pour chacune des demandes de nouvel utilisateur étudiant (AKA juste une en ce moment)
        for($i = 2; $i <= 2; $i++)
        {
            // Les demandes, dans cette mise en situation, auront 3 photos d'identité chacun
            for($j = 1; $j <= 3; $j++)

            /* Les paths des photos bidon sont:
                public/img/tests/photo_identite_1.jpg,
                public/img/tests/photo_identite_2.jpg,
                public/img/tests/photo_identite_3.jpg,
                d'où la concaténation du path avec la variable $j.
            */
            DB::table('photos_identite')->insert([
                'id_demande' => $i,
                'path' => 'photo_identite_' . $j . '.jpg',
            ]);
        }
    }
}
