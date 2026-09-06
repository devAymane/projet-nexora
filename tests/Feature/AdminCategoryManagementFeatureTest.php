<?php

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use App\Models\Service;
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

function createAdmin(): User
{
    $user = User::factory()->create();

    $user->addRole('admin');

    return $user;
}

function createClient(): User
{
    $user = User::factory()->create();

    $user->addRole('client');

    return $user;
}

function createProvider(): User
{
    $user = User::factory()->create();

    $user->addRole('provider');

    return $user;
}

/*
|--------------------------------------------------------------------------
| Access
|--------------------------------------------------------------------------
*/

it('allows admin to view categories', function () {
    $admin = createAdmin();

    Category::factory()->count(3)->create();

    $response = $this->actingAs($admin)
        ->get(route('categories.index'));

    $response->assertOk();
    $response->assertViewIs('categories.index');
    $response->assertViewHas('categories');
});

it('blocks guest from categories management', function () {
    $response = $this->get(route('categories.index'));

    $response->assertRedirect(route('login'));
});

it('blocks client from categories management', function () {
    $client = createClient();

    $response = $this->actingAs($client)
        ->get(route('categories.index'));

    $response->assertForbidden();
});

it('blocks provider from categories management', function () {
    $provider = createProvider();

    $response = $this->actingAs($provider)
        ->get(route('categories.index'));

    $response->assertForbidden();
});

/*
|--------------------------------------------------------------------------
| Create
|--------------------------------------------------------------------------
*/

it('allows admin to open create category page', function () {
    $admin = createAdmin();

    $response = $this->actingAs($admin)
        ->get(route('categories.create'));

    $response->assertOk();
    $response->assertViewIs('categories.create');
});

it('allows admin to create a category', function () {
    $admin = createAdmin();

    $response = $this->actingAs($admin)
        ->post(route('categories.store'), [
            'nom' => 'Développement Web',
            'description' => 'Services de développement web.',
        ]);

    $response->assertRedirect(route('categories.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('categories', [
        'nom' => 'Développement Web',
        'description' => 'Services de développement web.',
    ]);
});

it('rejects invalid category creation data', function () {
    $admin = createAdmin();

    $response = $this->actingAs($admin)
        ->post(route('categories.store'), [
            'nom' => '',
            'description' => 'Test',
        ]);

    $response->assertSessionHasErrors('nom');
});

it('rejects duplicate category name', function () {
    $admin = createAdmin();

    Category::factory()->create([
        'nom' => 'Développement Web',
    ]);

    $response = $this->actingAs($admin)
        ->post(route('categories.store'), [
            'nom' => 'Développement Web',
            'description' => 'Another description.',
        ]);

    $response->assertSessionHasErrors('nom');
});

/*
|--------------------------------------------------------------------------
| Show
|--------------------------------------------------------------------------
*/

it('allows admin to view a category', function () {
    $admin = createAdmin();

    $category = Category::factory()->create();

    $response = $this->actingAs($admin)
        ->get(route('categories.show', $category));

    $response->assertOk();
    $response->assertViewIs('categories.show');
    $response->assertViewHas('category');
});

it('allows admin to open edit category page', function () {
    $admin = createAdmin();

    $category = Category::factory()->create();

    $response = $this->actingAs($admin)
        ->get(route('categories.edit', $category));

    $response->assertOk();
    $response->assertViewIs('categories.edit');
    $response->assertViewHas('category');
});

/*
|--------------------------------------------------------------------------
| Update
|--------------------------------------------------------------------------
*/

it('allows admin to update a category', function () {
    $admin = createAdmin();

    $category = Category::factory()->create([
        'nom' => 'Ancienne catégorie',
        'description' => 'Ancienne description.',
    ]);

    $response = $this->actingAs($admin)
        ->put(route('categories.update', $category), [
            'nom' => 'Nouvelle catégorie',
            'description' => 'Nouvelle description.',
        ]);

    $response->assertRedirect(route('categories.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'nom' => 'Nouvelle catégorie',
        'description' => 'Nouvelle description.',
    ]);
});

it('rejects duplicate category name during update', function () {
    $admin = createAdmin();

    $category1 = Category::factory()->create([
        'nom' => 'Design',
    ]);

    $category2 = Category::factory()->create([
        'nom' => 'Développement',
    ]);

    $response = $this->actingAs($admin)
        ->put(route('categories.update', $category2), [
            'nom' => 'Design',
            'description' => 'Updated description.',
        ]);

    $response->assertSessionHasErrors('nom');

    expect($category1->fresh()->nom)->toBe('Design');
});

/*
|--------------------------------------------------------------------------
| Delete
|--------------------------------------------------------------------------
*/

it('allows admin to delete an empty category', function () {
    $admin = createAdmin();

    $category = Category::factory()->create();

    $response = $this->actingAs($admin)
        ->delete(route('categories.destroy', $category));

    $response->assertRedirect(route('categories.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('categories', [
        'id' => $category->id,
    ]);
});

it('prevents admin from deleting a category containing services', function () {
    $admin = createAdmin();

    $provider = createProvider();

    $category = Category::factory()->create();

    Service::factory()->create([
        'user_id' => $provider->id,
        'category_id' => $category->id,
    ]);

    $response = $this->actingAs($admin)
        ->delete(route('categories.destroy', $category));

    $response->assertRedirect(route('categories.index'));
    $response->assertSessionHas('error');

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
    ]);
});