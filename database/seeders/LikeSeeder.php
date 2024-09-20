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
                $post = random_int(0, 50);

                if(!in_array($user, $arr))
                {
                    array_push($arr, $user);
                    array_push($arr[$user], $post);
                }

                else if($arr[$user] != $post)
                    array_push($arr[$user], $post);
                    break;
            }
            DB::table('likes')->insert([
                'id_user' => $user,
                'id_article' => $post
            ]);
        }
    }
}
