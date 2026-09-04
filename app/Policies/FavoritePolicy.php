<?php

namespace App\Policies;

use App\Models\Favorite;
use App\Models\User;

class FavoritePolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole('client');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('client');
    }

    public function delete(User $user, Favorite $favorite): bool
    {
        return $user->hasRole('client')
            && $favorite->user_id === $user->id;
    }
}