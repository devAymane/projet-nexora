<?php

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

it('allows clients and providers to view any reservations', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    expect($client->can('viewAny', Reservation::class))->toBeTrue();
    expect($provider->can('viewAny', Reservation::class))->toBeTrue();
});

it('allows an admin to view any reservations', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    expect($admin->can('viewAny', Reservation::class))->toBeTrue();
});

it('allows a client to view their own reservation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
    ]);

    expect($client->can('view', $reservation))->toBeTrue();
});

it('blocks a client from viewing another clients reservation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $otherClient = User::factory()->create();
    $otherClient->addRole('client');

    $reservation = Reservation::factory()->create([
        'user_id' => $otherClient->id,
    ]);

    expect($client->can('view', $reservation))->toBeFalse();
});

it('allows a provider to view a reservation for their service', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $service = Service::factory()->create([
        'user_id' => $provider->id,
    ]);

    $reservation = Reservation::factory()->create([
        'service_id' => $service->id,
    ]);

    expect($provider->can('view', $reservation))->toBeTrue();
});

it('blocks a provider from viewing a reservation for another providers service', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $otherProvider = User::factory()->create();
    $otherProvider->addRole('provider');

    $service = Service::factory()->create([
        'user_id' => $otherProvider->id,
    ]);

    $reservation = Reservation::factory()->create([
        'service_id' => $service->id,
    ]);

    expect($provider->can('view', $reservation))->toBeFalse();
});

it('allows a client to create a reservation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    expect($client->can('create', Reservation::class))->toBeTrue();
});

it('blocks a provider from creating a reservation', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    expect($provider->can('create', Reservation::class))->toBeFalse();
});

it('allows a client to update their own reservation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
    ]);

    expect($client->can('update', $reservation))->toBeTrue();
});

it('blocks a client from updating another clients reservation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $otherClient = User::factory()->create();
    $otherClient->addRole('client');

    $reservation = Reservation::factory()->create([
        'user_id' => $otherClient->id,
    ]);

    expect($client->can('update', $reservation))->toBeFalse();
});

it('allows a client to delete their own reservation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
    ]);

    expect($client->can('delete', $reservation))->toBeTrue();
});

it('blocks a client from deleting another clients reservation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $otherClient = User::factory()->create();
    $otherClient->addRole('client');

    $reservation = Reservation::factory()->create([
        'user_id' => $otherClient->id,
    ]);

    expect($client->can('delete', $reservation))->toBeFalse();
});

it('allows a provider to manage reservations for their own services', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $service = Service::factory()->create([
        'user_id' => $provider->id,
    ]);

    $reservation = Reservation::factory()->create([
        'service_id' => $service->id,
    ]);

    expect($provider->can('manage', $reservation))->toBeTrue();
});

it('blocks a provider from managing reservations for another providers service', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $otherProvider = User::factory()->create();
    $otherProvider->addRole('provider');

    $service = Service::factory()->create([
        'user_id' => $otherProvider->id,
    ]);

    $reservation = Reservation::factory()->create([
        'service_id' => $service->id,
    ]);

    expect($provider->can('manage', $reservation))->toBeFalse();
});

it('allows an admin to perform all reservation abilities', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $reservation = Reservation::factory()->create();

    expect($admin->can('viewAny', Reservation::class))->toBeTrue();
    expect($admin->can('view', $reservation))->toBeTrue();
    expect($admin->can('create', Reservation::class))->toBeTrue();
    expect($admin->can('update', $reservation))->toBeTrue();
    expect($admin->can('delete', $reservation))->toBeTrue();
    expect($admin->can('manage', $reservation))->toBeTrue();
});