<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            // Aucune dépendance externe : permanent
            EtatArticleSeeder::class,
            EtatTransactionSeeder::class,
            EtatDemandeSeeder::class,
            TypeDemandeSeeder::class,
            TypeNotificationSeeder::class,

            // Aucune dépendance externe : temporaire
            MotCleSeeder::class,
            QuestionSecuriteSeeder::class,
            VilleSeeder::class,
            ThemeSeeder::class,
            CompagnieLivraisonSeeder::class,
            ReseauSeeder::class,

            // Dépendances externes
            UserSeeder::class,
            ModerateurSeeder::class,
            ArtisteSeeder::class,
            ArticleSeeder::class,
            DemandeSeeder::class,
            SignalementSeeder::class,
            LikeSeeder::class,
            FollowSeeder::class,
            ReseauArtisteSeeder::class,
            MotCleArticleSeeder::class,
            PhotoArticleSeeder::class,
            CommandeSeeder::class,

            ]);
    }
}
