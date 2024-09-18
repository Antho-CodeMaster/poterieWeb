<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'ADMINISTRATEUR',
            'email' => 'administrateur@terracium.com',
            'password' => 'poterie'
        ]);

        User::factory()->create([
            'name' => 'MODÉRATEUR',
            'email' => 'moderateur@terracium.com',
            'password' => 'poterie'
        ]);

        User::factory()->create([
            'name' => 'CLIENT',
            'email' => 'client@terracium.com',
            'password' => 'poterie'
        ]);

        User::factory()->create([
            'name' => 'ARTISTE PROFESSIONNEL',
            'email' => 'artiste_pro@terracium.com',
            'password' => 'poterie'
        ]);

        User::factory()->create([
            'name' => 'ARTISTE ÉTUDIANT',
            'email' => 'artiste_etu@terracium.com',
            'password' => 'poterie'
        ]);

        User::factory()->create([
            'name' => 'Simon Dubé',
            'email' => 'simondub098@gmail.com',
            'password' => 'poterie'
        ]);

        User::factory()->create([
            'name' => 'Nicola Filiatreault',
            'email' => 'nicolafiliatreault@gmail.com',
            'password' => 'despot'
        ]);

        User::factory()->create([
            'name' => 'Anthony Samson',
            'email' => 'lambdawavefunction@gmail.com',
            'password' => 'poterie'
        ]);

        User::factory()->create([
            'name' => 'Hamid Adelyar',
            'email' => 'hamid_adelyar@hotmail.com',
            'password' => 'poterie'
        ]);

        // 10 utilisateurs qui seront artistes.
        User::factory(10)->create();
    }
}
