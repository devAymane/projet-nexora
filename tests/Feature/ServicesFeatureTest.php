<?php

use App\Models\Category;
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

it('allows anyone to view the published services list', function () {
    Service::factory()->create([
        'statut' => 'publie',
    ]);

    Service::factory()->create([
        'statut' => 'brouillon',
    ]);

    $response = $this->get(route('services.index'));

    $response
        ->assertOk()
        ->assertViewIs('services.index');

    expect($response->viewData('services'))->toHaveCount(1);
});

it('allows searching published services by title', function () {
    $matchingService = Service::factory()->create([
        'titre' => 'Développement Laravel',
        'statut' => 'publie',
    ]);

    Service::factory()->create([
        'titre' => 'Design graphique',
        'statut' => 'publie',
    ]);

    $response = $this->get(route('services.index', [
        'search' => 'Laravel',
    ]));

    $response->assertOk();

    $services = $response->viewData('services');

    expect($services->pluck('id')->all())
        ->toContain($matchingService->id);

    expect($services->total())->toBe(1);
});

it('allows filtering published services by category', function () {
    $category = Category::factory()->create();

    $matchingService = Service::factory()->create([
        'category_id' => $category->id,
        'statut' => 'publie',
    ]);

    Service::factory()->create([
        'statut' => 'publie',
    ]);

    $response = $this->get(route('services.index', [
        'category' => $category->id,
    ]));

    $response->assertOk();

    $services = $response->viewData('services');

    expect($services->pluck('id')->all())
        ->toContain($matchingService->id);

    expect($services->total())->toBe(1);
});

it('allows viewing a published service', function () {
    $service = Service::factory()->create([
        'statut' => 'publie',
    ]);

    $response = $this->get(
        route('services.show', $service)
    );

    $response
        ->assertOk()
        ->assertViewIs('services.show')
        ->assertViewHas('service', $service);
});

it('returns 404 when viewing an unpublished service', function () {
    $service = Service::factory()->create([
        'statut' => 'brouillon',
    ]);

    $response = $this->get(
        route('services.show', $service)
    );

    $response->assertNotFound();
});

it('allows a provider to access the create service page', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $response = $this
        ->actingAs($provider)
        ->get(route('services.create'));

    $response
        ->assertOk()
        ->assertViewIs('services.create')
        ->assertViewHas('categories');
});

it('allows a provider to create a service', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $category = Category::factory()->create();

    $response = $this
        ->actingAs($provider)
        ->post(route('services.store'), [
            'category_id' => $category->id,
            'titre' => 'Création site Laravel',
            'description' => 'Je développe votre application Laravel.',
            'prix' => 1500,
            'ville' => 'Casablanca',
            'disponibilite' => true,
        ]);

    $response
        ->assertRedirect(route('services.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('services', [
        'user_id' => $provider->id,
        'category_id' => $category->id,
        'titre' => 'Création site Laravel',
        'prix' => 1500,
        'ville' => 'Casablanca',
        'statut' => 'brouillon',
        'disponibilite' => true,
    ]);
});

it('prevents a client from creating a service', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $category = Category::factory()->create();

    $response = $this
        ->actingAs($client)
        ->post(route('services.store'), [
            'category_id' => $category->id,
            'titre' => 'Service interdit',
            'description' => 'Ce service ne doit pas être créé.',
            'prix' => 500,
            'ville' => 'Rabat',
            'disponibilite' => true,
        ]);

    $response->assertForbidden();

    $this->assertDatabaseMissing('services', [
        'titre' => 'Service interdit',
    ]);
});

it('allows a provider to update their own service', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $category = Category::factory()->create();

    $service = Service::factory()->create([
        'user_id' => $provider->id,
        'category_id' => $category->id,
        'statut' => 'brouillon',
    ]);

    $response = $this
        ->actingAs($provider)
        ->put(route('services.update', $service), [
            'category_id' => $category->id,
            'titre' => 'Service Laravel modifié',
            'description' => 'Description modifiée.',
            'prix' => 2000,
            'ville' => 'Marrakech',
            'disponibilite' => true,
            'statut' => 'publie',
        ]);

    $response
        ->assertRedirect(route('services.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('services', [
        'id' => $service->id,
        'user_id' => $provider->id,
        'titre' => 'Service Laravel modifié',
        'prix' => 2000,
        'ville' => 'Marrakech',
        'statut' => 'publie',
    ]);
});

it('prevents a provider from updating another providers service', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $otherProvider = User::factory()->create();
    $otherProvider->addRole('provider');

    $category = Category::factory()->create();

    $service = Service::factory()->create([
        'user_id' => $otherProvider->id,
        'category_id' => $category->id,
        'statut' => 'brouillon',
    ]);

    $response = $this
        ->actingAs($provider)
        ->put(route('services.update', $service), [
            'category_id' => $category->id,
            'titre' => 'Modification interdite',
            'description' => 'Ne doit pas être modifié.',
            'prix' => 999,
            'ville' => 'Fès',
            'disponibilite' => true,
            'statut' => 'publie',
        ]);

    $response->assertForbidden();

    $this->assertDatabaseMissing('services', [
        'id' => $service->id,
        'titre' => 'Modification interdite',
    ]);
});

it('allows a provider to delete their own service', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $service = Service::factory()->create([
        'user_id' => $provider->id,
    ]);

    $response = $this
        ->actingAs($provider)
        ->delete(route('services.destroy', $service));

    $response
        ->assertRedirect(route('services.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('services', [
        'id' => $service->id,
    ]);
});