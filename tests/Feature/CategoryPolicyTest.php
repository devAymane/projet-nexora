<?php

use App\Models\Category;
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

it('allows an admin to perform all category abilities', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $category = Category::factory()->create();

    expect($admin->can('viewAny', Category::class))->toBeTrue();
    expect($admin->can('view', $category))->toBeTrue();
    expect($admin->can('create', Category::class))->toBeTrue();
    expect($admin->can('update', $category))->toBeTrue();
    expect($admin->can('delete', $category))->toBeTrue();
});

it('allows a user with view-categories permission to view categories', function () {
    $user = User::factory()->create();
    $user->permissions()->attach(
        \Laratrust\Models\Permission::where('name', 'view-categories')->firstOrCreate([
            'name' => 'view-categories',
            'display_name' => 'View Categories',
        ])
    );

    $category = Category::factory()->create();

    expect($user->can('viewAny', Category::class))->toBeTrue();
    expect($user->can('view', $category))->toBeTrue();
});

it('allows a user with create-categories permission to create categories', function () {
    $user = User::factory()->create();

    $permission = \Laratrust\Models\Permission::firstOrCreate([
        'name' => 'create-categories',
    ], [
        'display_name' => 'Create Categories',
    ]);

    $user->permissions()->attach($permission);

    expect($user->can('create', Category::class))->toBeTrue();
});

it('allows a user with edit-categories permission to update categories', function () {
    $user = User::factory()->create();

    $permission = \Laratrust\Models\Permission::firstOrCreate([
        'name' => 'edit-categories',
    ], [
        'display_name' => 'Edit Categories',
    ]);

    $user->permissions()->attach($permission);

    $category = Category::factory()->create();

    expect($user->can('update', $category))->toBeTrue();
});

it('allows a user with delete-categories permission to delete categories', function () {
    $user = User::factory()->create();

    $permission = \Laratrust\Models\Permission::firstOrCreate([
        'name' => 'delete-categories',
    ], [
        'display_name' => 'Delete Categories',
    ]);

    $user->permissions()->attach($permission);

    $category = Category::factory()->create();

    expect($user->can('delete', $category))->toBeTrue();
});

it('blocks users without category permissions', function () {
    $user = User::factory()->create();

    $category = Category::factory()->create();

    expect($user->can('viewAny', Category::class))->toBeFalse();
    expect($user->can('view', $category))->toBeFalse();
    expect($user->can('create', Category::class))->toBeFalse();
    expect($user->can('update', $category))->toBeFalse();
    expect($user->can('delete', $category))->toBeFalse();
});