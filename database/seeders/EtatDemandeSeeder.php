<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtatDemandeSeeder extends Seeder
{
    /**
     * Ces enregistrements devront être conservés en tout temps dans la base de données.
     */
    public function run(): void
    {
        DB::table('etats_demande')->insert([
            'etat' => 'En attente',
        ]);

        DB::table('etats_demande')->insert([
            'etat' => 'Accepté',
        ]);

        DB::table('etats_demande')->insert([
            'etat' => 'Refusé',
        ]);
    }
}
