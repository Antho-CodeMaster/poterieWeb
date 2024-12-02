<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemandeSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés.
     */
    public function run(): void
    {

        //Demande acceptée de nouveau professionnel faite par Simon

        DB::table('demandes')->insert([
            'id_type' => 1,
            'id_etat' => 2,
            'id_user' => 6,
        ]);

        //Demande en attente de nouvel étudiant faite par Nicola

        DB::table('demandes')->insert([
            'id_type' => 2,
            'id_etat' => 1,
            'id_user' => 7,
        ]);

        //Demande refusée de renouvellement faite par Anthony

        DB::table('demandes')->insert([
            'id_type' => 3,
            'id_etat' => 3,
            'id_user' => 8,
        ]);

        for($i = 0; $i < 50; $i++)
        {
            DB::table('demandes')->insert([
                'id_type' => random_int(1, 3),
                'id_etat' => 1,
                'id_user' => random_int(1, 9),
            ]);
        }
    }
}
