<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artiste>
 */
class ArtisteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_user' => 9, //Cette valeur ne devrait jamais être appelée, car elle doit être passée en paramètre par le seeder.
            'id_theme' => random_int(1, 4),
            'nom_artiste' => fake()->name(),
            'path_photo_profil' => 'img/artistePFP/default_artiste.png',
            'is_etudiant' => random_int(0, 1),
            'description' => fake()->sentence(random_int(5, 10), true),
            'couleur_banniere' => '808080'
        ];
    }
}
