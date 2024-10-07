<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $unique = random_int(0, 1);
        return [
            'id_artiste' => random_int(1, 12),
            'id_etat' => random_int(1, 3),
            'nom' => fake()->words(random_int(1, 6), true),
            'description' => fake()->sentence(),
            'prix' => $unique == 1 ? fake()->randomFloat(2, 1, 9999) : fake()->randomFloat(2, 1, 99),
            'hauteur' => fake()->randomFloat(2, 0, 100),
            'largeur' => fake()->randomFloat(2, 0, 100),
            'profondeur' => fake()->randomFloat(2, 0, 100),
            'poids' => fake()->randomFloat(2, 0, 500),
            'couleur' => fake()->word(),
            'quantite_disponible' => $unique == 1 ? 1 : random_int(1, 50),
            'date_publication' => now(),
            'is_en_vedette' => random_int(0, 1),
            'is_sensible' => random_int(0, 1),
            'is_alimentaire' => random_int(0, 1),
            'is_unique' => $unique,
        ];
    }
}
