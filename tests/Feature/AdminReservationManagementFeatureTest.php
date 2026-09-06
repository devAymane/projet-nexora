<?php

use App\Models\Category;
use App\Models\Reservation;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::create([
        'name' => 'admin',
        'display_name' => 'Admin',
        'description' => 'Administrator',
    ]);

    Role::create([
        'name' => 'client',
        'display_name' => 'Client',
        'description' => 'Client',
    ]);

    Role::create([
        'name' => 'provider',
        'display_name' => 'Provider',
        'description' => 'Provider',
    ]);
});

function createAdmin(): User
{
    $user = User::factory()->create();
    $user->addRole('admin');

    return $user;
}

function createClient(): User
{
    $user = User::factory()->create();
    $user->addRole('client');

    return $user;
}

function createProvider(): User
{
    $user = User::factory()->create();
    $user->addRole('provider');

    return $user;
}

function createService(User $provider): Service
{
    $category = Category::factory()->create();

    return Service::factory()->create([
        'user_id' => $provider->id,
        'category_id' => $category->id,
        'statut' => 'publie',
        'disponibilite' => true,
    ]);
}

function createReservation(User $client, Service $service, string $status = 'en_attente'): Reservation
{
    return Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => $status,
    ]);
}

it('allows admin to view all reservations', function () {
    $admin = createAdmin();

    $client = createClient();
    $provider = createProvider();
    $service = createService($provider);

    createReservation($client, $service);

    $response = $this->actingAs($admin)
        ->get(route('reservations.index'));

    $response->assertOk();
    $response->assertViewIs('reservations.index');
    $response->assertViewHas('reservations');
});

it('allows admin to view reservation details', function () {
    $admin = createAdmin();

    $client = createClient();
    $provider = createProvider();
    $service = createService($provider);
    $reservation = createReservation($client, $service);

    $response = $this->actingAs($admin)
        ->get(route('reservations.show', $reservation));

    $response->assertOk();
    $response->assertViewIs('reservations.show');
    $response->assertViewHas('reservation');
});

it('allows admin to accept a pending reservation', function () {
    $admin = createAdmin();

    $client = createClient();
    $provider = createProvider();
    $service = createService($provider);
    $reservation = createReservation($client, $service, 'en_attente');

    $response = $this->actingAs($admin)
        ->patch(route('reservations.accept', $reservation));

    $response->assertRedirect(route('reservations.index'));

    expect($reservation->fresh()->statut)->toBe('acceptee');
});

it('allows admin to refuse a pending reservation', function () {
    $admin = createAdmin();

    $client = createClient();
    $provider = createProvider();
    $service = createService($provider);
    $reservation = createReservation($client, $service, 'en_attente');

    $response = $this->actingAs($admin)
        ->patch(route('reservations.refuse', $reservation));

    $response->assertRedirect(route('reservations.index'));

    expect($reservation->fresh()->statut)->toBe('refusee');
});

it('allows admin to complete an accepted reservation', function () {
    $admin = createAdmin();

    $client = createClient();
    $provider = createProvider();
    $service = createService($provider);
    $reservation = createReservation($client, $service, 'acceptee');

    $response = $this->actingAs($admin)
        ->patch(route('reservations.complete', $reservation));

    $response->assertRedirect(route('reservations.index'));

    expect($reservation->fresh()->statut)->toBe('terminee');
});

it('blocks client from managing a reservation', function () {
    $client = createClient();

    $reservationOwner = createClient();
    $provider = createProvider();
    $service = createService($provider);

    $reservation = createReservation(
        $reservationOwner,
        $service,
        'en_attente'
    );

    $response = $this->actingAs($client)
        ->patch(route('reservations.accept', $reservation));

    $response->assertForbidden();

    expect($reservation->fresh()->statut)->toBe('en_attente');
});

it('allows provider to manage reservation of their own service', function () {
    $client = createClient();
    $provider = createProvider();
    $service = createService($provider);

    $reservation = createReservation($client, $service, 'en_attente');

    $response = $this->actingAs($provider)
        ->patch(route('reservations.accept', $reservation));

    $response->assertRedirect(route('reservations.index'));

    expect($reservation->fresh()->statut)->toBe('acceptee');
});

it('blocks provider from managing another provider reservation', function () {
    $client = createClient();

    $providerOne = createProvider();
    $providerTwo = createProvider();

    $service = createService($providerOne);

    $reservation = createReservation(
        $client,
        $service,
        'en_attente'
    );

    $response = $this->actingAs($providerTwo)
        ->patch(route('reservations.accept', $reservation));

    $response->assertForbidden();

    expect($reservation->fresh()->statut)->toBe('en_attente');
});