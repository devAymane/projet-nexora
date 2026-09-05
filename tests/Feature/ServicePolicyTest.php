<?php

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

it('allows an admin to do everything with a service', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $service = Service::factory()->create();

    expect($admin->can('view', $service))->toBeTrue();
    expect($admin->can('update', $service))->toBeTrue();
    expect($admin->can('delete', $service))->toBeTrue();
    expect($admin->can('create', Service::class))->toBeTrue();
});

it('allows a provider to create a service', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    expect($provider->can('create', Service::class))->toBeTrue();
});

it('allows a provider to update their own service', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $service = Service::factory()->create([
        'user_id' => $provider->id,
    ]);

    expect($provider->can('update', $service))->toBeTrue();
});

it('allows a provider to delete their own service', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $service = Service::factory()->create([
        'user_id' => $provider->id,
    ]);

    expect($provider->can('delete', $service))->toBeTrue();
});

it('blocks a provider from updating another providers service', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $otherProvider = User::factory()->create();
    $otherProvider->addRole('provider');

    $service = Service::factory()->create([
        'user_id' => $otherProvider->id,
    ]);

    expect($provider->can('update', $service))->toBeFalse();
});

it('blocks a provider from deleting another providers service', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $otherProvider = User::factory()->create();
    $otherProvider->addRole('provider');

    $service = Service::factory()->create([
        'user_id' => $otherProvider->id,
    ]);

    expect($provider->can('delete', $service))->toBeFalse();
});

it('blocks a client from creating a service', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    expect($client->can('create', Service::class))->toBeFalse();
});

it('blocks a client from updating a service', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $service = Service::factory()->create();

    expect($client->can('update', $service))->toBeFalse();
});

it('blocks a client from deleting a service', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $service = Service::factory()->create();

    expect($client->can('delete', $service))->toBeFalse();
});

it('allows authenticated users to view published services', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $service = Service::factory()->create([
        'statut' => 'publie',
    ]);

    expect($client->can('view', $service))->toBeTrue();
});

it('blocks authenticated users from viewing unpublished services', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $service = Service::factory()->create([
        'statut' => 'brouillon',
    ]);

    expect($client->can('view', $service))->toBeFalse();
});