<?php

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::create([
        'name' => 'client',
        'display_name' => 'Client',
        'description' => 'Client role',
    ]);

    Role::create([
        'name' => 'provider',
        'display_name' => 'Provider',
        'description' => 'Provider role',
    ]);

    $this->client = User::factory()->create();
    $this->client->addRole('client');

    $this->provider = User::factory()->create();
    $this->provider->addRole('provider');

    $this->otherClient = User::factory()->create();
    $this->otherClient->addRole('client');

    $this->otherProvider = User::factory()->create();
    $this->otherProvider->addRole('provider');

    $this->conversation = Conversation::factory()->create([
        'client_id' => $this->client->id,
        'provider_id' => $this->provider->id,
    ]);

    $this->otherConversation = Conversation::factory()->create([
        'client_id' => $this->otherClient->id,
        'provider_id' => $this->otherProvider->id,
    ]);
});

test('a participant can view the conversation messages', function () {
    Message::factory()->create([
        'conversation_id' => $this->conversation->id,
        'user_id' => $this->client->id,
        'contenu' => 'Bonjour provider',
    ]);

    $response = $this
        ->actingAs($this->client)
        ->get(route('conversations.show', $this->conversation));

    $response->assertSuccessful();
    $response->assertViewHas('conversation');
});

test('a client can send a message', function () {
    $response = $this
        ->actingAs($this->client)
        ->post(route('messages.store', $this->conversation), [
            'contenu' => 'Bonjour, je suis intéressé par votre service.',
        ]);

    $response->assertRedirect(
        route('conversations.show', $this->conversation)
    );

    $this->assertDatabaseHas('messages', [
        'conversation_id' => $this->conversation->id,
        'user_id' => $this->client->id,
        'contenu' => 'Bonjour, je suis intéressé par votre service.',
        'lu' => false,
    ]);
});

test('a provider can send a message', function () {
    $response = $this
        ->actingAs($this->provider)
        ->post(route('messages.store', $this->conversation), [
            'contenu' => 'Bonjour, comment puis-je vous aider ?',
        ]);

    $response->assertRedirect(
        route('conversations.show', $this->conversation)
    );

    $this->assertDatabaseHas('messages', [
        'conversation_id' => $this->conversation->id,
        'user_id' => $this->provider->id,
        'contenu' => 'Bonjour, comment puis-je vous aider ?',
        'lu' => false,
    ]);
});

test('a guest cannot send a message', function () {
    $response = $this->post(
        route('messages.store', $this->conversation),
        [
            'contenu' => 'Message test',
        ]
    );

    $response->assertRedirect(route('login'));
});

test('a user cannot send a message in another conversation', function () {
    $response = $this
        ->actingAs($this->client)
        ->post(route('messages.store', $this->otherConversation), [
            'contenu' => 'Message interdit',
        ]);

    $response->assertForbidden();

    $this->assertDatabaseMissing('messages', [
        'conversation_id' => $this->otherConversation->id,
        'user_id' => $this->client->id,
        'contenu' => 'Message interdit',
    ]);
});

test('message content is required', function () {
    $response = $this
        ->actingAs($this->client)
        ->post(route('messages.store', $this->conversation), [
            'contenu' => '',
        ]);

    $response->assertSessionHasErrors('contenu');
});

test('message content cannot exceed 2000 characters', function () {
    $response = $this
        ->actingAs($this->client)
        ->post(route('messages.store', $this->conversation), [
            'contenu' => str_repeat('a', 2001),
        ]);

    $response->assertSessionHasErrors('contenu');
});

test('opening a conversation marks unread incoming messages as read', function () {
    $message = Message::factory()->create([
        'conversation_id' => $this->conversation->id,
        'user_id' => $this->provider->id,
        'contenu' => 'Message non lu',
        'lu' => false,
    ]);

    $this
        ->actingAs($this->client)
        ->get(route('conversations.show', $this->conversation));

    expect($message->refresh()->lu)->toBeTrue();
});

test('a user cannot view another users conversation', function () {
    $response = $this
        ->actingAs($this->client)
        ->get(route('conversations.show', $this->otherConversation));

    $response->assertForbidden();
});