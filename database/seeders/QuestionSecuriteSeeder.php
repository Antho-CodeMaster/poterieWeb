<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSecuriteSeeder extends Seeder
{
    /**
     * Ces enregistrements devront être conservés en tout temps dans la base de données.
     */
    public function run(): void
    {
        DB::table('questions_securite')->insert([
            'question' => 'Quel est le nom de la rue sur laquelle vous avez grandi(e) ?',
        ]);

        DB::table('questions_securite')->insert([
            'question' => 'Quel est le premier concert auquel vous avez assisté ?',
        ]);

        DB::table('questions_securite')->insert([
            'question' => 'Quels étaient le fabricant et le modèle de votre première voiture ?',
        ]);

        DB::table('questions_securite')->insert([
            'question' => 'Dans quelle ville vos parents se sont-ils rencontrés ?',
        ]);

        DB::table('questions_securite')->insert([
            'question' => 'Quel est le nom de votre premier ami d’enfance ?',
        ]);

        DB::table('questions_securite')->insert([
            'question' => 'Quel est le nom de votre premier animal de compagnie ?',
        ]);
    }
}
