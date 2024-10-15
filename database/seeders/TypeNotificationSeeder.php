<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeNotificationSeeder extends Seeder
{
    /**
     * Ces enregistrements devront être conservés en tout temps dans la base de données.
     */
    public function run(): void
    {
        DB::table('types_notification')->insert([
            'description' => 'ATTENTION: un administrateur vous a averti pour la raison suivante: [1]',
        ]);

        DB::table('types_notification')->insert([
            'description' => 'Votre demande pour devenir vendeur a été refusée. Raison: [1]',
        ]);

        DB::table('types_notification')->insert([
            'description' => 'Votre demande pour devenir vendeur a été acceptée! Vous avez maintenant accès à votre kiosque dans la barre de navigation.',
        ]);
    }
}
