<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotCleArticleSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés.
     */
    public function run(): void
    {
        $arr = [];
        for($i = 0; $i < 50; $i++){
            //Générer des paires article-mot-clé à l'infini, et des conditions "break" seront appelées si les paires sont uniques.
            while (true)
            {
                $article = random_int(1, 50);
                $mot_cle = random_int(1, 87);

                // Si l'article n'avait aucun mot-clé encore
                if(!in_array($article, $arr))
                {
                    $arr[$article] = [];
                    array_push($arr[$article], $mot_cle);
                    break;
                }

                // Si l'article avait déjà un/des mot(s)-clé(s), mais qu'il n'avait pas encore le mot-clé généré
                else if(!in_array($mot_cle, $arr[$article]))
                {
                    array_push($arr[$article], $mot_cle);
                    break;
                }
            }
            DB::table('mots_cles_articles')->insert([
                'id_mot_cle' => $mot_cle,
                'id_article' => $article,
            ]);
        }
    }
}
