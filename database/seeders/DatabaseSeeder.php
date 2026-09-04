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
        | Laratrust Roles & Permissions
        |--------------------------------------------------------------------------
        */

        $this->call(LaratrustSeeder::class);

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        // Admin
        $admin = User::factory()->create();
        $admin->addRole('admin');

        // Clients
        $clients = User::factory(4)->create();

        foreach ($clients as $client) {
            $client->addRole('client');
        }

        // Providers
        $providers = User::factory(5)->create();

        foreach ($providers as $provider) {
            $provider->addRole('provider');
        }

        // Tous les utilisateurs
        $users = $clients
            ->merge($providers)
            ->push($admin);

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
            'user_id' => fn () => $providers->random()->id,
            'category_id' => fn () => $categories->random()->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Reservations
        |--------------------------------------------------------------------------
        */

        // 5 réservations en cours
        $reservations = Reservation::factory(5)->create([
            'user_id' => fn () => $clients->random()->id,
            'service_id' => fn () => $services->random()->id,
        ]);

        // 5 réservations terminées
        $completedReservations = Reservation::factory(5)
            ->terminee()
            ->create([
                'user_id' => fn () => $clients->random()->id,
                'service_id' => fn () => $services->random()->id,
            ]);

        $reservations = $reservations->merge($completedReservations);

        /*
        |--------------------------------------------------------------------------
        | Conversations
        |--------------------------------------------------------------------------
        */

        $conversations = collect();
        $conversationPairs = [];

        for ($i = 0; $i < 5; $i++) {
            do {
                $client = $clients->random();
                $provider = $providers->random();

                $key = $client->id . '-' . $provider->id;
            } while (in_array($key, $conversationPairs, true));

            $conversationPairs[] = $key;

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
                    'date_envoi' => fake()->dateTimeBetween(
                        '-30 days',
                        'now'
                    ),
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

        foreach ($clients as $client) {
            $service = $services->random();

            $key = $client->id . '-' . $service->id;

            if (! in_array($key, $favoritePairs, true)) {
                $favoritePairs[] = $key;

                Favorite::create([
                    'user_id' => $client->id,
                    'service_id' => $service->id,
                    'date' => now(),
                ]);
            }
        }
    }
}