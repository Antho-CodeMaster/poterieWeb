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
        // ID: 1
        User::factory()->create([
            'name' => 'Léo Filiatreault',
            'email' => 'leofiliatreault.business@gmail.com',
            'password' => 'Terracium/Goose420'
        ]);

        // ID: 2
        User::factory()->create([
            'name' => 'MODÉRATEUR',
            'email' => 'moderateur@terracium.com',
            'password' => 'poterie'
        ]);

        // ID: 3
        User::factory()->create([
            'name' => 'CLIENT',
            'email' => 'client@terracium.com',
            'password' => 'poterie'
        ]);

        // ID: 4
        User::factory()->create([
            'name' => 'ARTISTE PROFESSIONNEL',
            'email' => 'artiste_pro@terracium.com',
            'password' => 'poterie'
        ]);

        // ID: 5
        User::factory()->create([
            'name' => 'ARTISTE ÉTUDIANT',
            'email' => 'artiste_etu@terracium.com',
            'password' => 'poterie'
        ]);

        // ID: 6
        User::factory()->create([
            'name' => 'Simon Dubé',
            'email' => 'simondub098@gmail.com',
            'password' => 'poterie'
        ]);

        // ID: 7
        User::factory()->create([
            'name' => 'Nicola Filiatreault',
            'email' => 'nicolafiliatreault@gmail.com',
            'password' => 'despot'
        ]);

        // ID: 8
        User::factory()->create([
            'name' => 'Anthony Samson',
            'email' => 'lambdawavefunction@gmail.com',
            'password' => 'poterie'
        ]);

        // ID: 9
        User::factory()->create([
            'name' => 'Hamid Adelyar',
            'email' => 'hamid_adelyar@hotmail.com',
            'password' => 'poterie'
        ]);

        // 10 utilisateurs qui seront artistes.
        // IDs: 10 - 19
        #User::factory(10)->create();

        // 10 utilisateurs qui seront des clients réguliers.
        // IDs: 20 - 29
        #User::factory(10)->create();
    }
}
