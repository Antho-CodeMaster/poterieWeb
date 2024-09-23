<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhotoArticleSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés.
     */
    public function run(): void
    {
        // Pour chacun des articles
        for($i = 1; $i <= 50; $i++)
        {
            // Les articles, dans cette mise en situation, auront entre 1 et 4 photos chacun
            for($j = 0; $j <= random_int(1, 4); $j++)

            /* Les paths des photos bidon sont:
                public/img/tests/pot_1.jpg,
                public/img/tests/pot_2.jpg,
                public/img/tests/pot_3.jpg,
                public/img/tests/pot_4.jpg,
                d'où la concaténation du path avec la variable $j.
            */
            DB::table('photos_articles')->insert([
                'id_article' => $i,
                'path' => 'tests/pot_' . $j . '.jpg',
            ]);
        }
    }
}
