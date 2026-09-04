<?php

namespace App\Policies;

use App\Models\Avis;
use App\Models\Reservation;
use App\Models\User;

class AvisPolicy
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
        return $user->hasRole('client')
            || $user->hasRole('provider');
    }

    public function create(User $user, Reservation $reservation): bool
    {
        return $user->hasRole('client')
            && $reservation->user_id === $user->id
            && $reservation->statut === 'terminee'
            && ! $reservation->avis()->exists();
    }

    public function view(User $user, Avis $avis): bool
    {
        return $avis->user_id === $user->id
            || $avis->service?->user_id === $user->id;
    }
}