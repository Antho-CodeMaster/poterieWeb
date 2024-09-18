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
            'date' => now()
        ]);

        //Demande en attente de nouvel étudiant faite par Nicola

        DB::table('demandes')->insert([
            'id_type' => 2,
            'id_etat' => 1,
            'id_user' => 7,
            'date' => now()
        ]);

        //Demande refusée de renouvellement faite par Anthony

        DB::table('demandes')->insert([
            'id_type' => 3,
            'id_etat' => 3,
            'id_user' => 8,
            'date' => now()
        ]);
    }
}
