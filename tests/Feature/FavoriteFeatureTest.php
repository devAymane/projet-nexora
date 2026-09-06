<?php

use App\Models\Favorite;
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

it('allows a client to view their favorites', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $service = Service::factory()->create([
        'statut' => 'publie',
    ]);

    Favorite::create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'date' => now(),
    ]);

    $response = $this->actingAs($client)
        ->get(route('favorites.index'));

    $response->assertOk()
        ->assertViewIs('favorites.index')
        ->assertViewHas('favorites');

    expect($response->viewData('favorites')->total())->toBe(1);
});

it('prevents a guest from viewing favorites', function () {
    $response = $this->get(route('favorites.index'));

    $response->assertRedirect(route('login'));
});

it('allows a client to add a service to favorites', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $service = Service::factory()->create([
        'statut' => 'publie',
    ]);

    $response = $this->actingAs($client)
        ->post(route('favorites.store', $service));

    $response->assertRedirect()
        ->assertSessionHas('success');

    $this->assertDatabaseHas('favorites', [
        'user_id' => $client->id,
        'service_id' => $service->id,
    ]);
});

it('does not create a duplicate favorite', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $service = Service::factory()->create([
        'statut' => 'publie',
    ]);

    Favorite::create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'date' => now(),
    ]);

    $this->actingAs($client)
        ->post(route('favorites.store', $service));

    expect(
        Favorite::where('user_id', $client->id)
            ->where('service_id', $service->id)
            ->count()
    )->toBe(1);
});

it('allows a client to remove their favorite', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $service = Service::factory()->create([
        'statut' => 'publie',
    ]);

    $favorite = Favorite::create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'date' => now(),
    ]);

    $response = $this->actingAs($client)
        ->delete(route('favorites.destroy', $service));

    $response->assertRedirect()
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('favorites', [
        'id' => $favorite->id,
    ]);
});

it('prevents a client from removing another clients favorite', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $otherClient = User::factory()->create();
    $otherClient->addRole('client');

    $service = Service::factory()->create([
        'statut' => 'publie',
    ]);

    $favorite = Favorite::create([
        'user_id' => $otherClient->id,
        'service_id' => $service->id,
        'date' => now(),
    ]);

    $response = $this->actingAs($client)
        ->delete(route('favorites.destroy', $service));

    $response->assertNotFound();

    $this->assertDatabaseHas('favorites', [
        'id' => $favorite->id,
    ]);
});

it('prevents a provider from adding a service to favorites', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $service = Service::factory()->create([
        'statut' => 'publie',
    ]);

    $response = $this->actingAs($provider)
        ->post(route('favorites.store', $service));

    $response->assertForbidden();

    $this->assertDatabaseMissing('favorites', [
        'user_id' => $provider->id,
        'service_id' => $service->id,
    ]);
});