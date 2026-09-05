<?php

use App\Models\Avis;
use App\Models\Reservation;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use App\Policies\AvisPolicy;
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

it('allows clients and providers to view reviews list', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    expect($client->can('viewAny', Avis::class))->toBeTrue();
    expect($provider->can('viewAny', Avis::class))->toBeTrue();
});

it('allows an admin to perform all review abilities', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $reservation = Reservation::factory()->create([
        'statut' => 'terminee',
    ]);

    $avis = Avis::factory()->create();

    $policy = app(AvisPolicy::class);

    // before() gives the admin full access.
    expect($policy->before($admin, 'create'))->toBeTrue();

    // Other abilities are resolved normally through Laravel Gate.
    expect($admin->can('viewAny', Avis::class))->toBeTrue();
    expect($admin->can('view', $avis))->toBeTrue();

    // Directly calling create() does not execute before(),
    // so we verify the actual policy hook separately.
    expect($policy->create($admin, $reservation))->toBeFalse();
});

it('allows a client to create a review for their completed reservation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'statut' => 'terminee',
    ]);

    $policy = app(AvisPolicy::class);

    expect($policy->create($client, $reservation))->toBeTrue();
});

it('blocks a client from reviewing another clients reservation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $otherClient = User::factory()->create();
    $otherClient->addRole('client');

    $reservation = Reservation::factory()->create([
        'user_id' => $otherClient->id,
        'statut' => 'terminee',
    ]);

    $policy = app(AvisPolicy::class);

    expect($policy->create($client, $reservation))->toBeFalse();
});

it('blocks a client from reviewing a non completed reservation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'statut' => 'en_attente',
    ]);

    $policy = app(AvisPolicy::class);

    expect($policy->create($client, $reservation))->toBeFalse();
});

it('blocks a client from creating a second review for the same reservation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'statut' => 'terminee',
    ]);

    Avis::factory()->create([
        'reservation_id' => $reservation->id,
        'user_id' => $client->id,
    ]);

    $policy = app(AvisPolicy::class);

    expect($policy->create($client, $reservation))->toBeFalse();
});

it('allows the review owner to view their review', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $avis = Avis::factory()->create([
        'user_id' => $client->id,
    ]);

    expect($client->can('view', $avis))->toBeTrue();
});

it('allows the service provider to view a review', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $service = Service::factory()->create([
        'user_id' => $provider->id,
    ]);

    $avis = Avis::factory()->create([
        'service_id' => $service->id,
    ]);

    expect($provider->can('view', $avis))->toBeTrue();
});