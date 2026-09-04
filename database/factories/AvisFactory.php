<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Avis>
 */
class AvisFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(),
            'user_id' => User::factory(),
            'service_id' => Service::factory(),
            'note' => fake()->numberBetween(1, 5),
            'commentaire' => fake()->optional()->paragraph(),
            'date' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}