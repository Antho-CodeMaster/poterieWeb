<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 10; $i++)
            DB::table('commandes')->insert([
                'id_user' => random_int(20, 29),
                'date' => now(),
                'no_civique' => fake()->buildingNumber(),
                'rue' => fake()->streetName(),
                'code_postal' => fake()->lexify('?X?X?X'),
                'id_ville' => random_int(1, 233)
            ]);
    }
}
