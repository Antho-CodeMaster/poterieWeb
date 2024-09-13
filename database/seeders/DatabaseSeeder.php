<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
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

    }
}
