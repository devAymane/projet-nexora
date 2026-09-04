<?php

namespace Database\Seeders;

use App\Models\Avis;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Favorite;
use App\Models\Message;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        $users = User::factory(10)->create();

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Category::factory(9)->create();

        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        */

        $services = Service::factory(15)->create([
            'user_id' => fn () => $users->random()->id,
            'category_id' => fn () => $categories->random()->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Reservations
        |--------------------------------------------------------------------------
        */

        $reservations = Reservation::factory(5)->create([
            'user_id' => fn () => $users->random()->id,
            'service_id' => fn () => $services->random()->id,
        ]);

        $completedReservations = Reservation::factory(5)
            ->terminee()
            ->create([
                'user_id' => fn () => $users->random()->id,
                'service_id' => fn () => $services->random()->id,
            ]);

        $reservations = $reservations->merge($completedReservations);

        /*
        |--------------------------------------------------------------------------
        | Conversations
        |--------------------------------------------------------------------------
        */

        $conversations = collect();

        for ($i = 0; $i < 5; $i++) {
            $client = $users->random();

            $provider = $users
                ->where('id', '!=', $client->id)
                ->random();

            $conversations->push(
                Conversation::create([
                    'client_id' => $client->id,
                    'provider_id' => $provider->id,
                ])
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Messages
        |--------------------------------------------------------------------------
        */

        foreach ($conversations as $conversation) {
            $participants = collect([
                $conversation->client_id,
                $conversation->provider_id,
            ]);

            for ($i = 0; $i < 5; $i++) {
                Message::create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $participants->random(),
                    'contenu' => fake()->sentence(),
                    'lu' => fake()->boolean(),
                    'date_envoi' => fake()->dateTimeBetween('-30 days', 'now'),
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Avis
        |--------------------------------------------------------------------------
        */

        foreach ($completedReservations as $reservation) {
            Avis::create([
                'reservation_id' => $reservation->id,
                'user_id' => $reservation->user_id,
                'service_id' => $reservation->service_id,
                'note' => fake()->numberBetween(1, 5),
                'commentaire' => fake()->sentence(),
                'date' => now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Favorites
        |--------------------------------------------------------------------------
        */

        $favoritePairs = [];

        foreach ($users as $user) {
            $service = $services->random();

            $key = $user->id . '-' . $service->id;

            if (! in_array($key, $favoritePairs, true)) {
                $favoritePairs[] = $key;

                Favorite::create([
                    'user_id' => $user->id,
                    'service_id' => $service->id,
                    'date' => now(),
                ]);
            }
        }
    }
}