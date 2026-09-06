<?php

use App\Models\Avis;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Reservation;
use App\Models\Service;
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

    Role::create([
        'name' => 'admin',
        'display_name' => 'Admin',
        'description' => 'Admin role',
    ]);

    $this->client = User::factory()->create();
    $this->client->addRole('client');

    $this->provider = User::factory()->create();
    $this->provider->addRole('provider');

    $this->admin = User::factory()->create();
    $this->admin->addRole('admin');

    $this->category = Category::factory()->create();

    $this->service = Service::factory()->create([
        'user_id' => $this->provider->id,
        'category_id' => $this->category->id,
        'statut' => 'publie',
    ]);

    $this->reservation = Reservation::factory()->create([
        'user_id' => $this->client->id,
        'service_id' => $this->service->id,
        'statut' => 'terminee',
    ]);
});

test('client can view own avis', function () {
    Avis::factory()->create([
        'reservation_id' => $this->reservation->id,
        'user_id' => $this->client->id,
        'service_id' => $this->service->id,
        'note' => 5,
    ]);

    $response = $this
        ->actingAs($this->client)
        ->get(route('avis.index'));

    $response->assertSuccessful();
    $response->assertViewHas('avis');
});

test('guest cannot view avis', function () {
    $response = $this->get(route('avis.index'));

    $response->assertRedirect(route('login'));
});

test('client can access avis creation form for completed reservation', function () {
    $response = $this
        ->actingAs($this->client)
        ->get(route('avis.create', $this->reservation));

    $response->assertSuccessful();
    $response->assertViewHas('reservation');
});

test('client can create an avis for completed reservation', function () {
    $response = $this
        ->actingAs($this->client)
        ->post(route('avis.store'), [
            'reservation_id' => $this->reservation->id,
            'note' => 5,
            'commentaire' => 'Excellent service.',
        ]);

    $response->assertRedirect(
        route('reservations.show', $this->reservation)
    );

    $this->assertDatabaseHas('avis', [
        'reservation_id' => $this->reservation->id,
        'user_id' => $this->client->id,
        'service_id' => $this->service->id,
        'note' => 5,
        'commentaire' => 'Excellent service.',
    ]);
});

test('provider cannot create an avis', function () {
    $response = $this
        ->actingAs($this->provider)
        ->post(route('avis.store'), [
            'reservation_id' => $this->reservation->id,
            'note' => 5,
            'commentaire' => 'Avis interdit.',
        ]);

    $response->assertForbidden();
});

test('client cannot create an avis for another client reservation', function () {
    $otherClient = User::factory()->create();
    $otherClient->addRole('client');

    $otherReservation = Reservation::factory()->create([
        'user_id' => $otherClient->id,
        'service_id' => $this->service->id,
        'statut' => 'terminee',
    ]);

    $response = $this
        ->actingAs($this->client)
        ->post(route('avis.store'), [
            'reservation_id' => $otherReservation->id,
            'note' => 5,
            'commentaire' => 'Avis interdit.',
        ]);

    $response->assertForbidden();
});

test('avis note must be between 1 and 5', function () {
    $response = $this
        ->actingAs($this->client)
        ->post(route('avis.store'), [
            'reservation_id' => $this->reservation->id,
            'note' => 6,
            'commentaire' => 'Note invalide.',
        ]);

    $response->assertSessionHasErrors('note');
});

test('avis note is required', function () {
    $response = $this
        ->actingAs($this->client)
        ->post(route('avis.store'), [
            'reservation_id' => $this->reservation->id,
            'commentaire' => 'Sans note.',
        ]);

    $response->assertSessionHasErrors('note');
});

test('avis cannot be created twice for the same reservation', function () {
    Avis::factory()->create([
        'reservation_id' => $this->reservation->id,
        'user_id' => $this->client->id,
        'service_id' => $this->service->id,
        'note' => 4,
    ]);

    $response = $this
        ->actingAs($this->client)
        ->post(route('avis.store'), [
            'reservation_id' => $this->reservation->id,
            'note' => 5,
            'commentaire' => 'Deuxième avis.',
        ]);

    $response->assertForbidden();
});

test('admin can view all avis', function () {
    Avis::factory()->create([
        'reservation_id' => $this->reservation->id,
        'user_id' => $this->client->id,
        'service_id' => $this->service->id,
        'note' => 5,
    ]);

    $response = $this
        ->actingAs($this->admin)
        ->get(route('avis.index'));

    $response->assertSuccessful();
    $response->assertViewHas('avis');
});