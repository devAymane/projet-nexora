<?php

use App\Models\Conversation;
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

it('allows clients and providers to view conversations list', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    expect($client->can('viewAny', Conversation::class))->toBeTrue();
    expect($provider->can('viewAny', Conversation::class))->toBeTrue();
});

it('allows a client to view their conversation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    $conversation = Conversation::factory()->create([
        'client_id' => $client->id,
        'provider_id' => $provider->id,
    ]);

    expect($client->can('view', $conversation))->toBeTrue();
});

it('allows a provider to view their conversation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    $conversation = Conversation::factory()->create([
        'client_id' => $client->id,
        'provider_id' => $provider->id,
    ]);

    expect($provider->can('view', $conversation))->toBeTrue();
});

it('blocks an unrelated user from viewing a conversation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    $otherUser = User::factory()->create();
    $otherUser->addRole('client');

    $conversation = Conversation::factory()->create([
        'client_id' => $client->id,
        'provider_id' => $provider->id,
    ]);

    expect($otherUser->can('view', $conversation))->toBeFalse();
});

it('allows clients and providers to create conversations', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    expect($client->can('create', Conversation::class))->toBeTrue();
    expect($provider->can('create', Conversation::class))->toBeTrue();
});

it('allows an admin to perform all conversation abilities', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $conversation = Conversation::factory()->create();

    expect($admin->can('viewAny', Conversation::class))->toBeTrue();
    expect($admin->can('view', $conversation))->toBeTrue();
    expect($admin->can('create', Conversation::class))->toBeTrue();
});