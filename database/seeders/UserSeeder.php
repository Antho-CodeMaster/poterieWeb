<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        User::factory()->create([
            'name' => 'Hamid Adelyar',
            'email' => 'Hamid_adelyar@hotmail.com',
            'password' => 'poterie'
        ]);
    }
}
