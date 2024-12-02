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
        // 10 utilisateurs qui seront artistes.
        // IDs: 10 - 19
        User::factory(10)->create();

        // 10 utilisateurs qui seront des clients réguliers.
        // IDs: 20 - 29
        User::factory(10)->create();
    }
}
