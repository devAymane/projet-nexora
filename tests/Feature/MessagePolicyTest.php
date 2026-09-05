<?php

use App\Models\Conversation;
use App\Models\Message;
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

it('allows a client to view messages in their conversation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    $conversation = Conversation::factory()->create([
        'client_id' => $client->id,
        'provider_id' => $provider->id,
    ]);

    $message = Message::factory()->create([
        'conversation_id' => $conversation->id,
        'user_id' => $client->id,
    ]);

    expect($client->can('view', $message))->toBeTrue();
});

it('allows a provider to view messages in their conversation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    $conversation = Conversation::factory()->create([
        'client_id' => $client->id,
        'provider_id' => $provider->id,
    ]);

    $message = Message::factory()->create([
        'conversation_id' => $conversation->id,
        'user_id' => $provider->id,
    ]);

    expect($provider->can('view', $message))->toBeTrue();
});

it('blocks an unrelated user from viewing a message', function () {
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

    $message = Message::factory()->create([
        'conversation_id' => $conversation->id,
        'user_id' => $client->id,
    ]);

    expect($otherUser->can('view', $message))->toBeFalse();
});

it('allows clients and providers to create messages', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    expect($client->can('create', Message::class))->toBeTrue();
    expect($provider->can('create', Message::class))->toBeTrue();
});

it('blocks users without a role from creating messages', function () {
    $user = User::factory()->create();

    expect($user->can('create', Message::class))->toBeFalse();
});

it('allows a user to update their own message', function () {
    $user = User::factory()->create();
    $user->addRole('client');

    $message = Message::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($user->can('update', $message))->toBeTrue();
});

it('blocks a user from updating another users message', function () {
    $user = User::factory()->create();
    $user->addRole('client');

    $otherUser = User::factory()->create();
    $otherUser->addRole('provider');

    $message = Message::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    expect($user->can('update', $message))->toBeFalse();
});

it('allows an admin to perform all message abilities', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $message = Message::factory()->create();

    expect($admin->can('view', $message))->toBeTrue();
    expect($admin->can('create', Message::class))->toBeTrue();
    expect($admin->can('update', $message))->toBeTrue();
});