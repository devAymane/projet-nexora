<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => fake()->unique()->randomElement([
                'Informatique',
                'Design',
                'Marketing',
                'Photographie',
                'Plomberie',
                'Électricité',
                'Cours particuliers',
                'Nettoyage',
                'Réparation',
            ]),
            'description' => fake()->sentence(),
        ];
    }
}