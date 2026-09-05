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

it('allows an admin to perform all user abilities', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $user = User::factory()->create();

    expect($admin->can('viewAny', User::class))->toBeTrue();
    expect($admin->can('view', $user))->toBeTrue();
    expect($admin->can('create', User::class))->toBeTrue();
    expect($admin->can('update', $user))->toBeTrue();
    expect($admin->can('delete', $user))->toBeTrue();
});

it('allows a user with view-users permission to view users', function () {
    $user = User::factory()->create();

    $permission = \Laratrust\Models\Permission::firstOrCreate([
        'name' => 'view-users',
    ], [
        'display_name' => 'View Users',
    ]);

    $user->permissions()->attach($permission);

    $otherUser = User::factory()->create();

    expect($user->can('viewAny', User::class))->toBeTrue();
    expect($user->can('view', $otherUser))->toBeTrue();
});

it('allows a user with manage-users permission to create users', function () {
    $user = User::factory()->create();

    $permission = \Laratrust\Models\Permission::firstOrCreate([
        'name' => 'manage-users',
    ], [
        'display_name' => 'Manage Users',
    ]);

    $user->permissions()->attach($permission);

    expect($user->can('create', User::class))->toBeTrue();
});

it('allows a user with manage-users permission to update users', function () {
    $user = User::factory()->create();

    $permission = \Laratrust\Models\Permission::firstOrCreate([
        'name' => 'manage-users',
    ], [
        'display_name' => 'Manage Users',
    ]);

    $user->permissions()->attach($permission);

    $otherUser = User::factory()->create();

    expect($user->can('update', $otherUser))->toBeTrue();
});

it('allows a user with manage-users permission to delete another user', function () {
    $user = User::factory()->create();

    $permission = \Laratrust\Models\Permission::firstOrCreate([
        'name' => 'manage-users',
    ], [
        'display_name' => 'Manage Users',
    ]);

    $user->permissions()->attach($permission);

    $otherUser = User::factory()->create();

    expect($user->can('delete', $otherUser))->toBeTrue();
});

it('blocks a user from deleting themselves', function () {
    $user = User::factory()->create();

    $permission = \Laratrust\Models\Permission::firstOrCreate([
        'name' => 'manage-users',
    ], [
        'display_name' => 'Manage Users',
    ]);

    $user->permissions()->attach($permission);

    expect($user->can('delete', $user))->toBeFalse();
});

it('blocks users without user permissions', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    expect($user->can('viewAny', User::class))->toBeFalse();
    expect($user->can('view', $otherUser))->toBeFalse();
    expect($user->can('create', User::class))->toBeFalse();
    expect($user->can('update', $otherUser))->toBeFalse();
    expect($user->can('delete', $otherUser))->toBeFalse();
});