<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeDemandeSeeder extends Seeder
{
    /**
     * Ces enregistrements devront être conservés en tout temps dans la base de données.
     */
    public function run(): void
    {
        DB::table('types_demande')->insert([
            'type' => 'Renouvellement',
        ]);

        DB::table('types_demande')->insert([
            'type' => 'Nouvel étudiant',
        ]);

        DB::table('types_demande')->insert([
            'type' => 'Nouveau professionnel',
        ]);
    }
}
