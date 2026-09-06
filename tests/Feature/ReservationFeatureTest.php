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

function reservationScenario(): array
{
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $client = User::factory()->create();
    $client->addRole('client');

    $category = Category::factory()->create();

    $service = Service::factory()->create([
        'user_id' => $provider->id,
        'category_id' => $category->id,
        'statut' => 'publie',
        'disponibilite' => true,
    ]);

    return [$provider, $client, $service];
}

/*
|--------------------------------------------------------------------------
| Index
|--------------------------------------------------------------------------
*/

it('allows a client to view their reservations', function () {
    [$provider, $client, $service] = reservationScenario();

    Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
    ]);

    $response = $this->actingAs($client)
        ->get(route('reservations.index'));

    $response->assertOk()
        ->assertViewIs('reservations.index')
        ->assertViewHas('reservations');
});

it('allows a provider to view reservations for their services', function () {
    [$provider, $client, $service] = reservationScenario();

    Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
    ]);

    $response = $this->actingAs($provider)
        ->get(route('reservations.index'));

    $response->assertOk()
        ->assertViewIs('reservations.index')
        ->assertViewHas('reservations');
});

/*
|--------------------------------------------------------------------------
| Create
|--------------------------------------------------------------------------
*/

it('allows a client to access the reservation creation page', function () {
    [$provider, $client, $service] = reservationScenario();

    $response = $this->actingAs($client)
        ->get(route('reservations.create', [
            'service_id' => $service->id,
        ]));

    $response->assertOk()
        ->assertViewIs('reservations.create')
        ->assertViewHas('services')
        ->assertViewHas('service', $service);
});

it('prevents a provider from accessing the reservation creation page', function () {
    [$provider, $client, $service] = reservationScenario();

    $response = $this->actingAs($provider)
        ->get(route('reservations.create'));

    $response->assertForbidden();
});

/*
|--------------------------------------------------------------------------
| Store
|--------------------------------------------------------------------------
*/

it('allows a client to create a reservation', function () {
    [$provider, $client, $service] = reservationScenario();

    $date = now()->addDays(2)->format('Y-m-d H:i');

    $response = $this->actingAs($client)
        ->post(route('reservations.store'), [
            'service_id' => $service->id,
            'date' => $date,
            'message' => 'Je souhaite réserver ce service.',
        ]);

    $response->assertRedirect(route('reservations.index'))
        ->assertSessionHas('success', 'Réservation créée avec succès.');

    $this->assertDatabaseHas('reservations', [
        'user_id' => $client->id,
        'service_id' => $service->id,
        'message' => 'Je souhaite réserver ce service.',
        'statut' => 'en_attente',
    ]);
});

it('prevents a provider from creating a reservation', function () {
    [$provider, $client, $service] = reservationScenario();

    $date = now()->addDays(2)->format('Y-m-d H:i');

    $response = $this->actingAs($provider)
        ->post(route('reservations.store'), [
            'service_id' => $service->id,
            'date' => $date,
            'message' => 'Reservation interdite.',
        ]);

    $response->assertForbidden();

    $this->assertDatabaseCount('reservations', 0);
});

it('requires authentication to create a reservation', function () {
    [$provider, $client, $service] = reservationScenario();

    $response = $this->post(route('reservations.store'), [
        'service_id' => $service->id,
        'date' => now()->addDays(2)->format('Y-m-d H:i'),
        'message' => 'Reservation.',
    ]);

    $response->assertRedirect(route('login'));
});

/*
|--------------------------------------------------------------------------
| Show
|--------------------------------------------------------------------------
*/

it('allows a client to view their own reservation', function () {
    [$provider, $client, $service] = reservationScenario();

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
    ]);

    $response = $this->actingAs($client)
        ->get(route('reservations.show', $reservation));

    $response->assertOk()
        ->assertViewIs('reservations.show')
        ->assertViewHas('reservation', $reservation);
});

it('allows a provider to view a reservation for their service', function () {
    [$provider, $client, $service] = reservationScenario();

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
    ]);

    $response = $this->actingAs($provider)
        ->get(route('reservations.show', $reservation));

    $response->assertOk()
        ->assertViewIs('reservations.show')
        ->assertViewHas('reservation', $reservation);
});

it('prevents a client from viewing another clients reservation', function () {
    [$provider, $client, $service] = reservationScenario();

    $otherClient = User::factory()->create();
    $otherClient->addRole('client');

    $reservation = Reservation::factory()->create([
        'user_id' => $otherClient->id,
        'service_id' => $service->id,
    ]);

    $response = $this->actingAs($client)
        ->get(route('reservations.show', $reservation));

    $response->assertForbidden();
});

/*
|--------------------------------------------------------------------------
| Cancel
|--------------------------------------------------------------------------
*/

it('allows a client to cancel their pending reservation', function () {
    [$provider, $client, $service] = reservationScenario();

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'en_attente',
    ]);

    $response = $this->actingAs($client)
        ->patch(route('reservations.cancel', $reservation));

    $response->assertRedirect(route('reservations.index'))
        ->assertSessionHas('success', 'Réservation annulée avec succès.');

    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'statut' => 'annulee',
    ]);
});

it('does not allow cancelling a non-pending reservation', function () {
    [$provider, $client, $service] = reservationScenario();

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'acceptee',
    ]);

    $response = $this->actingAs($client)
        ->patch(route('reservations.cancel', $reservation));

    $response->assertRedirect()
        ->assertSessionHas(
            'error',
            'Cette réservation ne peut plus être annulée.'
        );

    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'statut' => 'acceptee',
    ]);
});

/*
|--------------------------------------------------------------------------
| Accept
|--------------------------------------------------------------------------
*/

it('allows a provider to accept a pending reservation for their service', function () {
    [$provider, $client, $service] = reservationScenario();

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'en_attente',
    ]);

    $response = $this->actingAs($provider)
        ->patch(route('reservations.accept', $reservation));

    $response->assertRedirect(route('reservations.index'))
        ->assertSessionHas('success', 'Réservation acceptée avec succès.');

    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'statut' => 'acceptee',
    ]);
});

it('does not allow accepting a non-pending reservation', function () {
    [$provider, $client, $service] = reservationScenario();

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'refusee',
    ]);

    $response = $this->actingAs($provider)
        ->patch(route('reservations.accept', $reservation));

    $response->assertRedirect()
        ->assertSessionHas(
            'error',
            'Cette réservation ne peut plus être acceptée.'
        );

    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'statut' => 'refusee',
    ]);
});

/*
|--------------------------------------------------------------------------
| Refuse
|--------------------------------------------------------------------------
*/

it('allows a provider to refuse a pending reservation for their service', function () {
    [$provider, $client, $service] = reservationScenario();

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'en_attente',
    ]);

    $response = $this->actingAs($provider)
        ->patch(route('reservations.refuse', $reservation));

    $response->assertRedirect(route('reservations.index'))
        ->assertSessionHas('success', 'Réservation refusée avec succès.');

    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'statut' => 'refusee',
    ]);
});

it('does not allow refusing a non-pending reservation', function () {
    [$provider, $client, $service] = reservationScenario();

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'acceptee',
    ]);

    $response = $this->actingAs($provider)
        ->patch(route('reservations.refuse', $reservation));

    $response->assertRedirect()
        ->assertSessionHas(
            'error',
            'Cette réservation ne peut plus être refusée.'
        );

    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'statut' => 'acceptee',
    ]);
});

/*
|--------------------------------------------------------------------------
| Complete
|--------------------------------------------------------------------------
*/

it('allows a provider to complete an accepted reservation', function () {
    [$provider, $client, $service] = reservationScenario();

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'acceptee',
    ]);

    $response = $this->actingAs($provider)
        ->patch(route('reservations.complete', $reservation));

    $response->assertRedirect(route('reservations.index'))
        ->assertSessionHas(
            'success',
            'Réservation marquée comme terminée.'
        );

    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'statut' => 'terminee',
    ]);
});

it('does not allow completing a non-accepted reservation', function () {
    [$provider, $client, $service] = reservationScenario();

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'en_attente',
    ]);

    $response = $this->actingAs($provider)
        ->patch(route('reservations.complete', $reservation));

    $response->assertRedirect()
        ->assertSessionHas(
            'error',
            'Seule une réservation acceptée peut être marquée comme terminée.'
        );

    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'statut' => 'en_attente',
    ]);
});

/*
|--------------------------------------------------------------------------
| Authorization
|--------------------------------------------------------------------------
*/

it('prevents a provider from managing another providers reservation', function () {
    [$provider, $client, $service] = reservationScenario();
    [$otherProvider, $otherClient, $otherService] = reservationScenario();

    $reservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $otherService->id,
        'statut' => 'en_attente',
    ]);

    $response = $this->actingAs($provider)
        ->patch(route('reservations.accept', $reservation));

    $response->assertForbidden();

    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'statut' => 'en_attente',
    ]);
});

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

it('validates reservation data', function () {
    [$provider, $client, $service] = reservationScenario();

    $response = $this->actingAs($client)
        ->post(route('reservations.store'), [
            'service_id' => 999999,
            'date' => 'invalid-date',
        ]);

    $response->assertSessionHasErrors([
        'service_id',
        'date',
    ]);
});