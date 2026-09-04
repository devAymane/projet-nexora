<?php

namespace App\Policies;

use App\Models\Avis;
use App\Models\Reservation;
use App\Models\User;

class AvisPolicy
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
     * Can the client create an avis for this reservation?
     */
    public function create(User $user, Reservation $reservation): bool
    {
        return $user->hasRole('client')
            && $reservation->user_id === $user->id
            && $reservation->statut === 'terminee'
            && ! $reservation->avis()->exists();
    }

    /**
     * Can the user view this avis?
     */
    public function view(User $user, Avis $avis): bool
    {
        return $avis->user_id === $user->id
            || $avis->service?->user_id === $user->id;
    }
}