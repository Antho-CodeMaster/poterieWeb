<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompagnieLivraisonSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés,
     * mais sont réalistes et les liens, une fois joints à un tracking ID, devraient fonctionner.
     */
    public function run(): void
    {
        DB::table('compagnies_livraison')->insert([
            'compagnie' => 'Purolator',
            'url' => 'https://www.purolator.com/fr/expedition/faire-le-suivi-dun-envoi?pins=',
        ]);

        DB::table('compagnies_livraison')->insert([
            'compagnie' => 'Postes Canada',
            'url' => 'https://www.canadapost-postescanada.ca/track-reperage/fr#/accueil',
        ]);

        DB::table('compagnies_livraison')->insert([
            'compagnie' => 'FedEx',
            'url' => 'https://www.fedex.com/wtrk/track/?action=track&trackingnumber=',
        ]);
    }
}
