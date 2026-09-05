<?php

use App\Models\Favorite;
use App\Models\Role;
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

it('allows a client to view favorites', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    expect($client->can('viewAny', Favorite::class))->toBeTrue();
});

it('allows a client to create a favorite', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    expect($client->can('create', Favorite::class))->toBeTrue();
});

it('allows a client to delete their own favorite', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $favorite = Favorite::factory()->create([
        'user_id' => $client->id,
    ]);

    expect($client->can('delete', $favorite))->toBeTrue();
});

it('blocks a client from deleting another clients favorite', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $otherClient = User::factory()->create();
    $otherClient->addRole('client');

    $favorite = Favorite::factory()->create([
        'user_id' => $otherClient->id,
    ]);

    expect($client->can('delete', $favorite))->toBeFalse();
});

it('blocks a provider from managing favorites', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $favorite = Favorite::factory()->create();

    expect($provider->can('viewAny', Favorite::class))->toBeFalse();
    expect($provider->can('create', Favorite::class))->toBeFalse();
    expect($provider->can('delete', $favorite))->toBeFalse();
});

it('allows an admin to perform all favorite abilities', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $favorite = Favorite::factory()->create();

    expect($admin->can('viewAny', Favorite::class))->toBeTrue();
    expect($admin->can('create', Favorite::class))->toBeTrue();
    expect($admin->can('delete', $favorite))->toBeTrue();
});