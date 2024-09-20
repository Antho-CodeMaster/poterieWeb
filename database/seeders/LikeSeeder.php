<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeSeeder extends Seeder
{
    /**
     * Ces enregistrements sont à des fins de tests et peuvent être supprimés.
     */
    public function run(): void
    {
        $arr = [];
        for($i = 0; $i < 20; $i++){
            while (true)
            {
                $user = random_int(20, 29);
                $article = random_int(1, 50);

                // Si le user n'avait rien liké avant
                if(!in_array($user, $arr))
                {
                    $arr[$user] = [];
                    array_push($arr[$user], $article);
                    break;
                }

                // Si le user avait déjà liké qqch, mais
                else if(!in_array($article, $arr[$user]))
                {
                    array_push($arr[$user], $article);
                    break;
                }
            }
            DB::table('likes')->insert([
                'id_user' => $user,
                'id_article' => $article
            ]);
        }
    }
}
