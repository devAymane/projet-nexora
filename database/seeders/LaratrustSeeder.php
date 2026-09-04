<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class LaratrustSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'admin',
            'display_name' => 'Administrateur',
            'description' => 'Gestion complète de la plateforme',
        ]);

        Role::firstOrCreate([
            'name' => 'client',
            'display_name' => 'Client',
            'description' => 'Utilisateur qui recherche et réserve des services',
        ]);

        Role::firstOrCreate([
            'name' => 'provider',
            'display_name' => 'Prestataire',
            'description' => 'Utilisateur qui propose des services',
        ]);
    }
}