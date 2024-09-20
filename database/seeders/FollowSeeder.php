<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowSeeder extends Seeder
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
                $artiste = random_int(1, 10);

                if(!in_array($user, $arr))
                {
                    $arr[$user] = [];
                    array_push($arr[$user], $artiste);
                    break;
                }

                else if(!in_array($artiste, $arr[$user]))
                {
                    array_push($arr[$user], $artiste);
                    break;
                }
            }
            DB::table('follows')->insert([
                'id_user' => $user,
                'id_artiste' => $artiste
            ]);
        }
    }
}
