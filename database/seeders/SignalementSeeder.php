<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SignalementSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés.
     */
    public function run(): void
    {
        DB::table('signalements')->insert([
            'id_user' => random_int(20, 29),
            'id_article' => random_int(1, 50),
            'date' => now(),
            'description' => fake()->sentence(),
        ]);
    }
}
