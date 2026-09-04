<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'service_id' => Service::factory(),
            'date' => fake()->dateTimeBetween('now', '+30 days'),
            'message' => fake()->optional()->sentence(),
            'statut' => fake()->randomElement([
                'en_attente',
                'acceptee',
                'refusee',
                'terminee',
                'annulee',
            ]),
        ];
    }

    public function terminee(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => 'terminee',
            'date' => fake()->dateTimeBetween('-30 days', '-1 day'),
        ]);
    }
}