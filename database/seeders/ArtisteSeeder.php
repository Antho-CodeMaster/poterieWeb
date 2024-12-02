<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Artiste;

class ArtisteSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés.
     */
    public function run(): void
    {
        for ($i = 10; $i < 20; $i++) {
            Artiste::factory()->create([
                'id_user' => $i
            ]);
        }
    }
}
