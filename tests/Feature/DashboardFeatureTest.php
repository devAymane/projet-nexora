<?php

use App\Models\Avis;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', [
        '--class' => 'LaratrustSeeder',
    ]);
});

function createDashboardUser(string $role): User
{
    $user = User::factory()->create();

    $user->addRole($role);

    return $user;
}

test('guest cannot access dashboard', function () {
    $response = $this->get('/dashboard');

    $response->assertRedirect('/login');
});

test('client is redirected to client dashboard', function () {
    $client = createDashboardUser('client');

    $response = $this->actingAs($client)
        ->get('/dashboard');

    $response->assertRedirect(route('client.dashboard'));
});

test('provider is redirected to provider dashboard', function () {
    $provider = createDashboardUser('provider');

    $response = $this->actingAs($provider)
        ->get('/dashboard');

    $response->assertRedirect(route('provider.dashboard'));
});

test('admin is redirected to admin dashboard', function () {
    $admin = createDashboardUser('admin');

    $response = $this->actingAs($admin)
        ->get('/dashboard');

    $response->assertRedirect(route('admin.dashboard'));
});

test('client can access client dashboard', function () {
    $client = createDashboardUser('client');

    $response = $this->actingAs($client)
        ->get(route('client.dashboard'));

    $response
        ->assertOk()
        ->assertViewIs('dashboards.client')
        ->assertViewHas('stats')
        ->assertViewHas('recentReservations')
        ->assertViewHas('recentFavorites');
});

test('provider can access provider dashboard', function () {
    $provider = createDashboardUser('provider');

    $response = $this->actingAs($provider)
        ->get(route('provider.dashboard'));

    $response
        ->assertOk()
        ->assertViewIs('dashboards.provider')
        ->assertViewHas('stats')
        ->assertViewHas('recentReservations');
});

test('admin can access admin dashboard', function () {
    $admin = createDashboardUser('admin');

    $response = $this->actingAs($admin)
        ->get(route('admin.dashboard'));

    $response
        ->assertOk()
        ->assertViewIs('dashboards.admin')
        ->assertViewHas('stats')
        ->assertViewHas('recentReservations');
});

test('client cannot access provider dashboard', function () {
    $client = createDashboardUser('client');

    $response = $this->actingAs($client)
        ->get(route('provider.dashboard'));

    $response->assertForbidden();
});

test('client cannot access admin dashboard', function () {
    $client = createDashboardUser('client');

    $response = $this->actingAs($client)
        ->get(route('admin.dashboard'));

    $response->assertForbidden();
});

test('provider cannot access client dashboard', function () {
    $provider = createDashboardUser('provider');

    $response = $this->actingAs($provider)
        ->get(route('client.dashboard'));

    $response->assertForbidden();
});

test('provider cannot access admin dashboard', function () {
    $provider = createDashboardUser('provider');

    $response = $this->actingAs($provider)
        ->get(route('admin.dashboard'));

    $response->assertForbidden();
});

test('admin cannot access client dashboard', function () {
    $admin = createDashboardUser('admin');

    $response = $this->actingAs($admin)
        ->get(route('client.dashboard'));

    $response->assertForbidden();
});

test('admin cannot access provider dashboard', function () {
    $admin = createDashboardUser('admin');

    $response = $this->actingAs($admin)
        ->get(route('provider.dashboard'));

    $response->assertForbidden();
});

test('client dashboard calculates reservation and favorite statistics', function () {
    $client = createDashboardUser('client');

    $service = Service::factory()->create();

    Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'en_attente',
    ]);

    Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'acceptee',
    ]);

    Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'terminee',
    ]);

    Favorite::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
    ]);

    $response = $this->actingAs($client)
        ->get(route('client.dashboard'));

    $stats = $response->viewData('stats');

    expect($stats['reservations'])->toBe(3)
        ->and($stats['pending'])->toBe(1)
        ->and($stats['accepted'])->toBe(1)
        ->and($stats['completed'])->toBe(1)
        ->and($stats['favorites'])->toBe(1);
});

test('provider dashboard calculates service reservation and review statistics', function () {
    $provider = createDashboardUser('provider');
    $client = createDashboardUser('client');

    $service = Service::factory()->create([
        'user_id' => $provider->id,
    ]);

    Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'en_attente',
    ]);

    Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'acceptee',
    ]);

    $completedReservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'terminee',
    ]);

    Avis::factory()->create([
        'reservation_id' => $completedReservation->id,
        'user_id' => $client->id,
        'service_id' => $service->id,
        'note' => 4,
    ]);

    $secondCompletedReservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $service->id,
        'statut' => 'terminee',
    ]);

    Avis::factory()->create([
        'reservation_id' => $secondCompletedReservation->id,
        'user_id' => $client->id,
        'service_id' => $service->id,
        'note' => 5,
    ]);

    $response = $this->actingAs($provider)
        ->get(route('provider.dashboard'));

    $stats = $response->viewData('stats');

    expect($stats['services'])->toBe(1)
        ->and($stats['pending'])->toBe(1)
        ->and($stats['accepted'])->toBe(1)
        ->and($stats['completed'])->toBe(2)
        ->and($stats['reviews'])->toBe(2)
        ->and($stats['rating'])->toBe(4.5);
});

test('admin dashboard calculates global statistics', function () {
    $admin = createDashboardUser('admin');
    $client = createDashboardUser('client');
    $provider = createDashboardUser('provider');

    $category = Category::factory()->create();

    $publishedService = Service::factory()->create([
        'user_id' => $provider->id,
        'category_id' => $category->id,
        'statut' => 'publie',
    ]);

    $draftService = Service::factory()->create([
        'user_id' => $provider->id,
        'category_id' => $category->id,
        'statut' => 'brouillon',
    ]);

    Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $publishedService->id,
        'statut' => 'en_attente',
    ]);

    $completedReservation = Reservation::factory()->create([
        'user_id' => $client->id,
        'service_id' => $publishedService->id,
        'statut' => 'terminee',
    ]);

    Avis::factory()->create([
        'reservation_id' => $completedReservation->id,
        'user_id' => $client->id,
        'service_id' => $publishedService->id,
        'note' => 5,
    ]);

    $response = $this->actingAs($admin)
        ->get(route('admin.dashboard'));

    $stats = $response->viewData('stats');

    expect($stats['users'])->toBe(3)
        ->and($stats['services'])->toBe(2)
        ->and($stats['publishedServices'])->toBe(1)
        ->and($stats['categories'])->toBe(1)
        ->and($stats['reservations'])->toBe(2)
        ->and($stats['pendingReservations'])->toBe(1)
        ->and($stats['completedReservations'])->toBe(1)
        ->and($stats['reviews'])->toBe(1);
});