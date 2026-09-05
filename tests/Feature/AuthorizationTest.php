<?php

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

it('allows a client to access the client dashboard', function () {
    $user = User::factory()->create();

    $user->addRole('client');

    $this->actingAs($user)
        ->get(route('client.dashboard'))
        ->assertOk();
});

it('allows a provider to access the provider dashboard', function () {
    $user = User::factory()->create();

    $user->addRole('provider');

    $this->actingAs($user)
        ->get(route('provider.dashboard'))
        ->assertOk();
});

it('allows an admin to access the admin dashboard', function () {
    $user = User::factory()->create();

    $user->addRole('admin');

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertOk();
});

it('blocks a client from the provider dashboard', function () {
    $user = User::factory()->create();

    $user->addRole('client');

    $this->actingAs($user)
        ->get(route('provider.dashboard'))
        ->assertForbidden();
});

it('blocks a client from the admin dashboard', function () {
    $user = User::factory()->create();

    $user->addRole('client');

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

it('blocks a provider from the client dashboard', function () {
    $user = User::factory()->create();

    $user->addRole('provider');

    $this->actingAs($user)
        ->get(route('client.dashboard'))
        ->assertForbidden();
});

it('blocks a provider from the admin dashboard', function () {
    $user = User::factory()->create();

    $user->addRole('provider');

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

it('blocks an admin from the client dashboard', function () {
    $user = User::factory()->create();

    $user->addRole('admin');

    $this->actingAs($user)
        ->get(route('client.dashboard'))
        ->assertForbidden();
});

it('blocks an admin from the provider dashboard', function () {
    $user = User::factory()->create();

    $user->addRole('admin');

    $this->actingAs($user)
        ->get(route('provider.dashboard'))
        ->assertForbidden();
});

it('blocks unauthenticated users from all dashboards', function () {
    $this->get(route('client.dashboard'))
        ->assertRedirect(route('login'));

    $this->get(route('provider.dashboard'))
        ->assertRedirect(route('login'));

    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});