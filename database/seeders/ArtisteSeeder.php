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
        // Compte Artiste pour ARTISTE PROFESSIONNEL

        Artiste::factory()->create([
            'id_user' => 4,
            'is_etudiant' => 0
        ]);

        // Compte Artiste pour ARTISTE ÉTUDIANT

        Artiste::factory()->create([
            'id_user' => 5,
            'is_etudiant' => 0
        ]);

        // Compte Artiste pour ARTISTE INACTIF compte HamidAdelyar

        Artiste::factory()->create([
            'id_user' => 9,
            'is_etudiant' => 0,
            'actif' => 0
        ]);

        for ($i = 10; $i < 20; $i++) {
            Artiste::factory()->create([
                'id_user' => $i
            ]);
        }
    }
}
