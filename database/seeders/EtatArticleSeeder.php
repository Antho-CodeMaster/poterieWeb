<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtatArticleSeeder extends Seeder
{
    /**
     * Ces enregistrements devront être conservés en tout temps dans la base de données.
     */
    public function run(): void
    {
        DB::table('etats_article')->insert([
            'etat' => 'Visible client',
        ]);

        DB::table('etats_article')->insert([
            'etat' => 'Masqué client',
        ]);

        DB::table('etats_article')->insert([
            'etat' => 'Masqué artiste / inactif',
        ]);
    }
}
