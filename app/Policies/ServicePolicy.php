<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    /**
     * Admin can do everything.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    /**
     * Anyone authenticated can view a service.
     */
    public function view(User $user, Service $service): bool
    {
        return $service->statut === 'publie';
    }

    /**
     * Only providers can create services.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('provider');
    }

    /**
     * Only the provider who owns the service can update it.
     */
    public function update(User $user, Service $service): bool
    {
        return $user->hasRole('provider')
            && $service->user_id === $user->id;
    }

    /**
     * Only the provider who owns the service can delete it.
     */
    public function delete(User $user, Service $service): bool
    {
        return $user->hasRole('provider')
            && $service->user_id === $user->id;
    }
}