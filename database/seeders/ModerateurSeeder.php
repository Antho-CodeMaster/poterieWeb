<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModerateurSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés.
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
