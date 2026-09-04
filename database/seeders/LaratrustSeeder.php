<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class LaratrustSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // ROLES
        // =========================

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'display_name' => 'Administrateur',
            'description' => 'Gestion complète de la plateforme',
        ]);

        $client = Role::firstOrCreate([
            'name' => 'client',
            'display_name' => 'Client',
            'description' => 'Utilisateur qui recherche et réserve des services',
        ]);

        $provider = Role::firstOrCreate([
            'name' => 'provider',
            'display_name' => 'Prestataire',
            'description' => 'Utilisateur qui propose des services',
        ]);

        // =========================
        // PERMISSIONS
        // =========================

        $permissions = [
            'view-users',
            'manage-users',

            'view-categories',
            'create-categories',
            'edit-categories',
            'delete-categories',

            'view-services',
            'create-services',
            'edit-services',
            'delete-services',

            'view-reservations',
            'create-reservations',
            'manage-reservations',

            'view-reviews',
            'create-reviews',
            'manage-reviews',

            'view-messages',
            'send-messages',

            'view-favorites',
            'manage-favorites',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
            ]);
        }

        // =========================
        // GET PERMISSIONS
        // =========================

        $allPermissions = Permission::all();

        // =========================
        // ADMIN
        // =========================

        $admin->syncPermissions($allPermissions);

        // =========================
        // CLIENT
        // =========================

        $clientPermissions = Permission::whereIn('name', [
            'view-services',

            'view-reservations',
            'create-reservations',

            'view-reviews',
            'create-reviews',

            'view-messages',
            'send-messages',

            'view-favorites',
            'manage-favorites',
        ])->get();

        $client->syncPermissions($clientPermissions);

        // =========================
        // PROVIDER
        // =========================

        $providerPermissions = Permission::whereIn('name', [
            'view-services',
            'create-services',
            'edit-services',
            'delete-services',

            'view-reservations',
            'manage-reservations',

            'view-reviews',
            'manage-reviews',

            'view-messages',
            'send-messages',
        ])->get();

        $provider->syncPermissions($providerPermissions);
    }
}