<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemeSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés.
     * Des enregistrements pertinents seront toutefois à conserver.
     */
    public function run(): void
    {
        DB::table('themes')->insert(['arriere_plan' => '14213D','en_vedette' => 'FCA311','article' => 'E5E5E5','bouton' => 'FFFFFF']);
        DB::table('themes')->insert(['arriere_plan' => '3C6E71','en_vedette' => 'FFFFFF','article' => 'D9D9D9','bouton' => '284B63']);
        DB::table('themes')->insert(['arriere_plan' => 'BFC0C0','en_vedette' => 'EF8354','article' => 'FFFFFF','bouton' => '4F5D75']);
        DB::table('themes')->insert(['arriere_plan' => 'FF5E5B','en_vedette' => 'D8D8D8','article' => '00CECB','bouton' => 'FFED66']);
    }
}
