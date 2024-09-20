<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReseauArtisteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reseaux_artistes')->insert(['id_reseau' => '3','id_artiste' => '1','username' => '@fern-tv']);
        DB::table('reseaux_artistes')->insert(['id_reseau' => '3','id_artiste' => '2','username' => '@chess']);
        DB::table('reseaux_artistes')->insert(['id_reseau' => '3','id_artiste' => '3','username' => '@MrBeast']);
        DB::table('reseaux_artistes')->insert(['id_reseau' => '3','id_artiste' => '4','username' => '@MarkRober']);
        DB::table('reseaux_artistes')->insert(['id_reseau' => '3','id_artiste' => '5','username' => '@MichaelReeves']);
        DB::table('reseaux_artistes')->insert(['id_reseau' => '2','id_artiste' => '2','username' => 'zuck']);
        DB::table('reseaux_artistes')->insert(['id_reseau' => '2','id_artiste' => '3','username' => 'facebook']);
        DB::table('reseaux_artistes')->insert(['id_reseau' => '2','id_artiste' => '4','username' => 'maisondesmetiersdartdequebec']);
        DB::table('reseaux_artistes')->insert(['id_reseau' => '2','id_artiste' => '5','username' => 'RadioCanada']);
        DB::table('reseaux_artistes')->insert(['id_reseau' => '2','id_artiste' => '6','username' => 'ReseauTVA']);
        DB::table('reseaux_artistes')->insert(['id_reseau' => '1','id_artiste' => '4','username' => 'cristiano']);
        DB::table('reseaux_artistes')->insert(['id_reseau' => '1','id_artiste' => '5','username' => 'instagram']);
        DB::table('reseaux_artistes')->insert(['id_reseau' => '1','id_artiste' => '6','username' => 'kyliejenner']);
        DB::table('reseaux_artistes')->insert(['id_reseau' => '1','id_artiste' => '7','username' => 'arianagrande']);
        DB::table('reseaux_artistes')->insert(['id_reseau' => '1','id_artiste' => '8','username' => 'taylorswift']);

    }
}
