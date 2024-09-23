<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReseauSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés,
     * mais sont réalistes et les liens, une fois joints à des usernames, devraient fonctionner.
     */
    public function run(): void
    {
        DB::table('reseaux')->insert([
            'reseau' => 'Instagram',
            'url' => 'https://www.instagram.com/',
        ]);

        DB::table('reseaux')->insert([
            'reseau' => 'Facebook',
            'url' => 'https://www.facebook.com/',
        ]);

        DB::table('reseaux')->insert([
            'reseau' => 'YouTube',
            'url' => 'https://www.youtube.com/@',
        ]);
    }
}
