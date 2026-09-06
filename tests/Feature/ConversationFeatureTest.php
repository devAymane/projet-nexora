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

it('allows a client to view their conversations', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    Conversation::factory()->create([
        'client_id' => $client->id,
        'provider_id' => $provider->id,
    ]);

    $response = $this->actingAs($client)
        ->get(route('conversations.index'));

    $response->assertOk()
        ->assertViewIs('conversations.index')
        ->assertViewHas('conversations');

    expect($response->viewData('conversations')->total())->toBe(1);
});

it('allows a provider to view their conversations', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    Conversation::factory()->create([
        'client_id' => $client->id,
        'provider_id' => $provider->id,
    ]);

    $response = $this->actingAs($provider)
        ->get(route('conversations.index'));

    $response->assertOk()
        ->assertViewIs('conversations.index')
        ->assertViewHas('conversations');

    expect($response->viewData('conversations')->total())->toBe(1);
});

it('prevents a guest from viewing conversations', function () {
    $response = $this->get(route('conversations.index'));

    $response->assertRedirect(route('login'));
});

it('allows a client to create a conversation with a provider', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    $response = $this->actingAs($client)
        ->get(route('conversations.create', $provider));

    $conversation = Conversation::first();

    $response->assertRedirect(
        route('conversations.show', $conversation)
    );

    expect($conversation)->not->toBeNull();

    expect($conversation->client_id)->toBe($client->id);
    expect($conversation->provider_id)->toBe($provider->id);
});

it('allows a provider to create a conversation with a client', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $client = User::factory()->create();
    $client->addRole('client');

    $response = $this->actingAs($provider)
        ->get(route('conversations.create', $client));

    $conversation = Conversation::first();

    $response->assertRedirect(
        route('conversations.show', $conversation)
    );

    expect($conversation)->not->toBeNull();

    expect($conversation->client_id)->toBe($client->id);
    expect($conversation->provider_id)->toBe($provider->id);
});

it('does not create a duplicate conversation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    Conversation::factory()->create([
        'client_id' => $client->id,
        'provider_id' => $provider->id,
    ]);

    $this->actingAs($client)
        ->get(route('conversations.create', $provider));

    expect(
        Conversation::where('client_id', $client->id)
            ->where('provider_id', $provider->id)
            ->count()
    )->toBe(1);
});

it('prevents a user from creating a conversation with themselves', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $response = $this->actingAs($client)
        ->get(route('conversations.create', $client));

    $response->assertForbidden();

    expect(Conversation::count())->toBe(0);
});

it('prevents a client from viewing another users conversation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $otherClient = User::factory()->create();
    $otherClient->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    $conversation = Conversation::factory()->create([
        'client_id' => $otherClient->id,
        'provider_id' => $provider->id,
    ]);

    $response = $this->actingAs($client)
        ->get(route('conversations.show', $conversation));

    $response->assertForbidden();
});

it('allows a participant to view their conversation', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $provider = User::factory()->create();
    $provider->addRole('provider');

    $conversation = Conversation::factory()->create([
        'client_id' => $client->id,
        'provider_id' => $provider->id,
    ]);

    $response = $this->actingAs($client)
        ->get(route('conversations.show', $conversation));

    $response->assertOk()
        ->assertViewIs('conversations.show')
        ->assertViewHas('conversation', $conversation);
});