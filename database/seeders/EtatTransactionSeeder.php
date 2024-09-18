<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtatTransactionSeeder extends Seeder
{
    /**
     * Ces enregistrements devront être conservés en tout temps dans la base de données.
     */
    public function run(): void
    {
        DB::table('etats_transaction')->insert([
            'etat' => 'Panier',
        ]);

        DB::table('etats_transaction')->insert([
            'etat' => 'En cours',
        ]);

        DB::table('etats_transaction')->insert([
            'etat' => 'Traité',
        ]);

        DB::table('etats_transaction')->insert([
            'etat' => 'Livré',
        ]);

        DB::table('etats_transaction')->insert([
            'etat' => 'Annulé',
        ]);
    }
}
