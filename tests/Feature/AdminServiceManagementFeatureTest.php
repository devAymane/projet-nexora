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

function makeAdmin(): User
{
    $user = User::factory()->create();
    $user->addRole('admin');

    return $user;
}

function makeClient(): User
{
    $user = User::factory()->create();
    $user->addRole('client');

    return $user;
}

function makeProvider(): User
{
    $user = User::factory()->create();
    $user->addRole('provider');

    return $user;
}

/*
|--------------------------------------------------------------------------
| Access to services
|--------------------------------------------------------------------------
*/

it('allows admin to view published services', function () {
    $admin = makeAdmin();

    Service::factory()->create([
        'statut' => 'publie',
    ]);

    Service::factory()->create([
        'statut' => 'brouillon',
    ]);

    $response = $this->actingAs($admin)
        ->get(route('services.index'));

    $response->assertOk();
    $response->assertViewIs('services.index');
    $response->assertViewHas('services');

    expect($response->viewData('services')->total())->toBe(1);
});

it('allows guest to view published services', function () {
    Service::factory()->create([
        'statut' => 'publie',
    ]);

    $response = $this->get(route('services.index'));

    $response->assertOk();
    $response->assertViewIs('services.index');
});

it('blocks client from creating services', function () {
    $client = makeClient();

    $response = $this->actingAs($client)
        ->get(route('services.create'));

    $response->assertForbidden();
});

it('allows provider to create services', function () {
    $provider = makeProvider();

    $response = $this->actingAs($provider)
        ->get(route('services.create'));

    $response->assertOk();
    $response->assertViewIs('services.create');
});

it('allows admin to open service creation page', function () {
    $admin = makeAdmin();

    $response = $this->actingAs($admin)
        ->get(route('services.create'));

    $response->assertOk();
    $response->assertViewIs('services.create');
});

/*
|--------------------------------------------------------------------------
| Create service
|--------------------------------------------------------------------------
*/

it('allows admin to create a service', function () {
    $admin = makeAdmin();
    $category = Category::factory()->create();

    $response = $this->actingAs($admin)
        ->post(route('services.store'), [
            'category_id' => $category->id,
            'titre' => 'Création de site web',
            'description' => 'Création de sites web professionnels.',
            'prix' => 1500,
            'ville' => 'Casablanca',
            'disponibilite' => true,
        ]);

    $response->assertRedirect(route('services.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('services', [
        'category_id' => $category->id,
        'user_id' => $admin->id,
        'titre' => 'Création de site web',
        'prix' => 1500,
        'ville' => 'Casablanca',
        'statut' => 'brouillon',
    ]);
});

it('allows provider to create a service', function () {
    $provider = makeProvider();
    $category = Category::factory()->create();

    $response = $this->actingAs($provider)
        ->post(route('services.store'), [
            'category_id' => $category->id,
            'titre' => 'Logo professionnel',
            'description' => 'Création de logo professionnel.',
            'prix' => 500,
            'ville' => 'Rabat',
            'disponibilite' => true,
        ]);

    $response->assertRedirect(route('services.index'));

    $this->assertDatabaseHas('services', [
        'user_id' => $provider->id,
        'titre' => 'Logo professionnel',
        'statut' => 'brouillon',
    ]);
});

it('blocks client from creating a service', function () {
    $client = makeClient();
    $category = Category::factory()->create();

    $response = $this->actingAs($client)
        ->post(route('services.store'), [
            'category_id' => $category->id,
            'titre' => 'Test service',
            'description' => 'Test description',
            'prix' => 500,
            'ville' => 'Fes',
        ]);

    $response->assertForbidden();
});

/*
|--------------------------------------------------------------------------
| Show service
|--------------------------------------------------------------------------
*/

it('allows admin to view a published service', function () {
    $admin = makeAdmin();

    $service = Service::factory()->create([
        'statut' => 'publie',
    ]);

    $response = $this->actingAs($admin)
        ->get(route('services.show', $service));

    $response->assertOk();
    $response->assertViewIs('services.show');
    $response->assertViewHas('service');
});

it('hides unpublished services from public show page', function () {
    $admin = makeAdmin();

    $service = Service::factory()->create([
        'statut' => 'brouillon',
    ]);

    $response = $this->actingAs($admin)
        ->get(route('services.show', $service));

    $response->assertNotFound();
});

/*
|--------------------------------------------------------------------------
| Update service
|--------------------------------------------------------------------------
*/

it('allows admin to edit a service', function () {
    $admin = makeAdmin();

    $service = Service::factory()->create([
        'statut' => 'publie',
    ]);

    $response = $this->actingAs($admin)
        ->get(route('services.edit', $service));

    $response->assertOk();
    $response->assertViewIs('services.edit');
    $response->assertViewHas('service');
});

it('allows admin to update a service', function () {
    $admin = makeAdmin();
    $category = Category::factory()->create();

    $service = Service::factory()->create([
        'statut' => 'brouillon',
    ]);

    $response = $this->actingAs($admin)
        ->put(route('services.update', $service), [
            'category_id' => $category->id,
            'titre' => 'Service mis à jour',
            'description' => 'Description mise à jour.',
            'prix' => 2000,
            'ville' => 'Marrakech',
            'disponibilite' => true,
            'statut' => 'publie',
        ]);

    $response->assertRedirect(route('services.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('services', [
        'id' => $service->id,
        'category_id' => $category->id,
        'titre' => 'Service mis à jour',
        'prix' => 2000,
        'ville' => 'Marrakech',
        'statut' => 'publie',
    ]);
});

it('allows provider to update their own service', function () {
    $provider = makeProvider();

    $service = Service::factory()->create([
        'user_id' => $provider->id,
    ]);

    $category = Category::factory()->create();

    $response = $this->actingAs($provider)
        ->put(route('services.update', $service), [
            'category_id' => $category->id,
            'titre' => 'Mon service modifié',
            'description' => 'Nouvelle description.',
            'prix' => 900,
            'ville' => 'Agadir',
            'disponibilite' => true,
            'statut' => 'publie',
        ]);

    $response->assertRedirect(route('services.index'));

    $this->assertDatabaseHas('services', [
        'id' => $service->id,
        'titre' => 'Mon service modifié',
        'statut' => 'publie',
    ]);
});

it('blocks provider from updating another provider service', function () {
    $provider1 = makeProvider();
    $provider2 = makeProvider();

    $service = Service::factory()->create([
        'user_id' => $provider1->id,
    ]);

    $response = $this->actingAs($provider2)
        ->get(route('services.edit', $service));

    $response->assertForbidden();
});

/*
|--------------------------------------------------------------------------
| Delete service
|--------------------------------------------------------------------------
*/

it('allows admin to delete a service', function () {
    $admin = makeAdmin();

    $service = Service::factory()->create();

    $response = $this->actingAs($admin)
        ->delete(route('services.destroy', $service));

    $response->assertRedirect(route('services.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('services', [
        'id' => $service->id,
    ]);
});

it('allows provider to delete their own service', function () {
    $provider = makeProvider();

    $service = Service::factory()->create([
        'user_id' => $provider->id,
    ]);

    $response = $this->actingAs($provider)
        ->delete(route('services.destroy', $service));

    $response->assertRedirect(route('services.index'));

    $this->assertDatabaseMissing('services', [
        'id' => $service->id,
    ]);
});

it('blocks provider from deleting another provider service', function () {
    $provider1 = makeProvider();
    $provider2 = makeProvider();

    $service = Service::factory()->create([
        'user_id' => $provider1->id,
    ]);

    $response = $this->actingAs($provider2)
        ->delete(route('services.destroy', $service));

    $response->assertForbidden();

    $this->assertDatabaseHas('services', [
        'id' => $service->id,
    ]);
});

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

it('rejects invalid service creation data', function () {
    $admin = makeAdmin();

    $response = $this->actingAs($admin)
        ->post(route('services.store'), [
            'titre' => '',
            'description' => '',
            'prix' => -100,
            'ville' => '',
        ]);

    $response->assertSessionHasErrors([
        'category_id',
        'titre',
        'description',
        'prix',
        'ville',
    ]);
});

it('rejects invalid service status during update', function () {
    $admin = makeAdmin();

    $service = Service::factory()->create();

    $category = Category::factory()->create();

    $response = $this->actingAs($admin)
        ->put(route('services.update', $service), [
            'category_id' => $category->id,
            'titre' => 'Service test',
            'description' => 'Description test.',
            'prix' => 500,
            'ville' => 'Oujda',
            'disponibilite' => true,
            'statut' => 'invalid_status',
        ]);

    $response->assertSessionHasErrors('statut');
});