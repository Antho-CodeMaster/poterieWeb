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
            'type' => '[1] a publié un nouvel article!',
        ]);

        DB::table('types_notification')->insert([
            'type' => 'ATTENTION: un administrateur vous a averti pour la raison suivante: [1]',
        ]);

        DB::table('types_notification')->insert([
            'type' => 'Votre commande est prête! Cliquez pour visualiser la commande.',
        ]);
    }
}
