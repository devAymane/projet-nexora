<?php

use App\Models\Avis;
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

function createAdminAvis(): User
{
    $user = User::factory()->create();
    $user->addRole('admin');

    return $user;
}

function createClientAvis(): User
{
    $user = User::factory()->create();
    $user->addRole('client');

    return $user;
}

function createProviderAvis(): User
{
    $user = User::factory()->create();
    $user->addRole('provider');

    return $user;
}

function createAvisService(User $provider): Service
{
    $category = Category::factory()->create();

    return Service::factory()->create([
        'user_id' => $provider->id,
        'category_id' => $category->id,
        'statut' => 'publie',
        'disponibilite' => true,
    ]);
}

function createCompletedReservationAvis(
    User $client,
    Service $service
): Reservation {
    return Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'terminee',
    ]);
}

function createTestAvis(
    User $client,
    Service $service
): Avis {
    $reservation = createCompletedReservationAvis($client, $service);

    return Avis::factory()->create([
        'reservation_id' => $reservation->id,
        'user_id' => $client->id,
        'service_id' => $service->id,
        'note' => 5,
        'commentaire' => 'Excellent service.',
        'date' => now(),
    ]);
}

it('allows admin to view all reviews', function () {
    $admin = createAdminAvis();

    $clientOne = createClientAvis();
    $clientTwo = createClientAvis();

    $providerOne = createProviderAvis();
    $providerTwo = createProviderAvis();

    $serviceOne = createAvisService($providerOne);
    $serviceTwo = createAvisService($providerTwo);

    createTestAvis($clientOne, $serviceOne);
    createTestAvis($clientTwo, $serviceTwo);

    $response = $this->actingAs($admin)
        ->get(route('avis.index'));

    $response->assertOk();
    $response->assertViewIs('avis.index');
    $response->assertViewHas('avis');

    expect($response->viewData('avis')->total())->toBe(2);
});

it('allows client to view their own reviews', function () {
    $client = createClientAvis();
    $otherClient = createClientAvis();

    $provider = createProviderAvis();
    $service = createAvisService($provider);

    createTestAvis($client, $service);
    createTestAvis($otherClient, $service);

    $response = $this->actingAs($client)
        ->get(route('avis.index'));

    $response->assertOk();

    $avis = $response->viewData('avis');

    expect($avis->total())->toBe(1);
    expect($avis->first()->user_id)->toBe($client->id);
});

it('allows provider to view reviews of their services', function () {
    $clientOne = createClientAvis();
    $clientTwo = createClientAvis();

    $provider = createProviderAvis();
    $otherProvider = createProviderAvis();

    $service = createAvisService($provider);
    $otherService = createAvisService($otherProvider);

    createTestAvis($clientOne, $service);
    createTestAvis($clientTwo, $otherService);

    $response = $this->actingAs($provider)
        ->get(route('avis.index'));

    $response->assertOk();

    $avis = $response->viewData('avis');

    expect($avis->total())->toBe(1);
    expect($avis->first()->service_id)->toBe($service->id);
});

it('blocks guest from viewing reviews', function () {
    $response = $this->get(route('avis.index'));

    $response->assertRedirect(route('login'));
});

it('allows admin to access reviews regardless of review ownership', function () {
    $admin = createAdminAvis();

    $client = createClientAvis();
    $provider = createProviderAvis();

    $service = createAvisService($provider);
    $avis = createTestAvis($client, $service);

    $response = $this->actingAs($admin)
        ->get(route('avis.index'));

    $response->assertOk();
    $response->assertViewHas('avis');

    expect($avis->user_id)->not->toBe($admin->id);
});