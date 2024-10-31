<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommandeSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés.
     */
    public function run(): void
    {
        for($i = 0; $i < 30; $i++)
            DB::table('commandes')->insert([
                'id_user' => random_int(20, 29),
                'date' => now(),
                'no_civique' => fake()->buildingNumber(),
                'rue' => fake()->streetName(),
                'code_postal' => fake()->bothify('?#?#?#'),
                'id_ville' => random_int(1, 233),
                'is_panier' => random_int(0,1)
            ]);

            //Commandes fixes pour démo
        DB::table('commandes')->insert([
            'id_user' => 3,
            'date' => now(),
            'no_civique' => fake()->buildingNumber(),
            'rue' => fake()->streetName(),
            'code_postal' => fake()->bothify('?#?#?#'),
            'id_ville' => random_int(1, 233),
            'is_panier' => 0
        ]);
        DB::table('commandes')->insert([
            'id_user' => 3,
            'date' => now(),
            'no_civique' => fake()->buildingNumber(),
            'rue' => fake()->streetName(),
            'code_postal' => fake()->bothify('?#?#?#'),
            'id_ville' => random_int(1, 233),
            'is_panier' => 0
        ]);
    }
}
