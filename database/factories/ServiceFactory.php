<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'titre' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'prix' => fake()->randomFloat(2, 50, 2000),
            'ville' => fake()->randomElement([
                'Casablanca',
                'Rabat',
                'Marrakech',
                'Tanger',
                'Fès',
                'Agadir',
                'Meknès',
                'Oujda',
            ]),
            'image' => null,
            'disponibilite' => true,
            'statut' => 'publie',
        ];
    }
}