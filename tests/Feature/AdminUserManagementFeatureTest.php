<?php

use App\Models\User;
use App\Models\Role;
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

/*
|--------------------------------------------------------------------------
| Access
|--------------------------------------------------------------------------
*/

it('allows admin to view users', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $response = $this->actingAs($admin)
        ->get(route('users.index'));

    $response->assertOk();
});

it('blocks guest from users management', function () {
    $response = $this->get(route('users.index'));

    $response->assertRedirect(route('login'));
});

it('blocks client from users management', function () {
    $client = User::factory()->create();
    $client->addRole('client');

    $response = $this->actingAs($client)
        ->get(route('users.index'));

    $response->assertForbidden();
});

it('blocks provider from users management', function () {
    $provider = User::factory()->create();
    $provider->addRole('provider');

    $response = $this->actingAs($provider)
        ->get(route('users.index'));

    $response->assertForbidden();
});

/*
|--------------------------------------------------------------------------
| Search & Filters
|--------------------------------------------------------------------------
*/

it('allows admin to search users', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $target = User::factory()->create([
        'nom' => 'Dupont',
        'prenom' => 'Jean',
        'email' => 'jean.dupont@example.com',
    ]);
    $target->addRole('client');

    User::factory()->create([
        'nom' => 'Martin',
        'prenom' => 'Paul',
        'email' => 'paul.martin@example.com',
    ]);

    $response = $this->actingAs($admin)
        ->get(route('users.index', [
            'search' => 'Dupont',
        ]));

    $response->assertOk()
        ->assertSee('jean.dupont@example.com')
        ->assertDontSee('paul.martin@example.com');
});

it('allows admin to filter users by role', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $client = User::factory()->create([
        'email' => 'client-filter@example.com',
    ]);
    $client->addRole('client');

    $provider = User::factory()->create([
        'email' => 'provider-filter@example.com',
    ]);
    $provider->addRole('provider');

    $response = $this->actingAs($admin)
        ->get(route('users.index', [
            'role' => 'provider',
        ]));

    $response->assertOk()
        ->assertSee('provider-filter@example.com')
        ->assertDontSee('client-filter@example.com');
});

/*
|--------------------------------------------------------------------------
| Create User
|--------------------------------------------------------------------------
*/

it('allows admin to create a user', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $response = $this->actingAs($admin)
        ->post(route('users.store'), [
            'nom' => 'Nouveau',
            'prenom' => 'Utilisateur',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

    $response->assertRedirect(route('users.index'));

    $user = User::where('email', 'newuser@example.com')->first();

    expect($user)->not->toBeNull();
    expect($user->hasRole('client'))->toBeTrue();
});

/*
|--------------------------------------------------------------------------
| Show / Edit
|--------------------------------------------------------------------------
*/

it('allows admin to view a user', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $user = User::factory()->create();
    $user->addRole('client');

    $response = $this->actingAs($admin)
        ->get(route('users.show', $user));

    $response->assertOk()
        ->assertViewIs('users.show');
});

it('allows admin to open edit user page', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $user = User::factory()->create();
    $user->addRole('client');

    $response = $this->actingAs($admin)
        ->get(route('users.edit', $user));

    $response->assertOk()
        ->assertViewIs('users.edit');
});

/*
|--------------------------------------------------------------------------
| Update User
|--------------------------------------------------------------------------
*/

it('allows admin to update a user', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $user = User::factory()->create([
        'nom' => 'Ancien',
        'prenom' => 'Nom',
        'email' => 'old@example.com',
    ]);
    $user->addRole('client');

    $response = $this->actingAs($admin)
        ->put(route('users.update', $user), [
            'nom' => 'Nouveau',
            'prenom' => 'Prenom',
            'email' => 'updated@example.com',
            'telephone' => '0600000000',
            'pays' => 'Maroc',
            'ville' => 'Casablanca',
            'description' => 'Description mise à jour',
        ]);

    $response->assertRedirect(route('users.index'));

    $user->refresh();

    expect($user->nom)->toBe('Nouveau');
    expect($user->prenom)->toBe('Prenom');
    expect($user->email)->toBe('updated@example.com');
});

/*
|--------------------------------------------------------------------------
| Update Role
|--------------------------------------------------------------------------
*/

it('allows admin to change a user role', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $user = User::factory()->create();
    $user->addRole('client');

    $response = $this->actingAs($admin)
        ->patch(route('users.update-role', $user), [
            'role' => 'provider',
        ]);

    $response->assertRedirect(route('users.index'));

    $user->refresh();

    expect($user->hasRole('provider'))->toBeTrue();
    expect($user->hasRole('client'))->toBeFalse();
});

it('rejects an invalid role', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $user = User::factory()->create();
    $user->addRole('client');

    $response = $this->actingAs($admin)
        ->patch(route('users.update-role', $user), [
            'role' => 'invalid-role',
        ]);

    $response->assertSessionHasErrors('role');

    expect($user->fresh()->hasRole('client'))->toBeTrue();
});

/*
|--------------------------------------------------------------------------
| Delete User
|--------------------------------------------------------------------------
*/

it('allows admin to delete another user', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $user = User::factory()->create();
    $user->addRole('client');

    $response = $this->actingAs($admin)
        ->delete(route('users.destroy', $user));

    $response->assertRedirect(route('users.index'));

    expect(User::find($user->id))->toBeNull();
});

it('prevents admin from deleting their own account', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $response = $this->actingAs($admin)
        ->delete(route('users.destroy', $admin));

    $response->assertRedirect(route('users.index'))
        ->assertSessionHas('error');

    expect(User::find($admin->id))->not->toBeNull();
});

/*
|--------------------------------------------------------------------------
| Own Role
|--------------------------------------------------------------------------
*/

it('prevents admin from changing their own role', function () {
    $admin = User::factory()->create();
    $admin->addRole('admin');

    $response = $this->actingAs($admin)
        ->patch(route('users.update-role', $admin), [
            'role' => 'client',
        ]);

    $response->assertRedirect(route('users.index'))
        ->assertSessionHas('error');

    expect($admin->fresh()->hasRole('admin'))->toBeTrue();
});