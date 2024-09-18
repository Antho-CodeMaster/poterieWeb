<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModerateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ADMINISTRATEUR
        DB::table('moderateurs')->insert([
            'id_user' => 1,
            'is_admin' => 1
        ]);

        // MODERATEUR
        DB::table('moderateurs')->insert([
            'id_user' => 2,
            'is_admin' => 0
        ]);
    }
}
