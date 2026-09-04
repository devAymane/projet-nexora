<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;

class ReservationPolicy
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

    public function view(User $user, Reservation $reservation): bool
    {
        // Client: uniquement ses propres réservations
        if ($user->hasRole('client')) {
            return $reservation->user_id === $user->id;
        }

        // Provider: uniquement les réservations de ses services
        if ($user->hasRole('provider')) {
            return $reservation->service?->user_id === $user->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('client');
    }

    public function update(User $user, Reservation $reservation): bool
    {
        // Client peut modifier uniquement sa réservation
        return $user->hasRole('client')
            && $reservation->user_id === $user->id;
    }

    public function delete(User $user, Reservation $reservation): bool
    {
        // Client peut supprimer/annuler uniquement sa réservation
        return $user->hasRole('client')
            && $reservation->user_id === $user->id;
    }

    public function manage(User $user, Reservation $reservation): bool
    {
        // Provider peut gérer les réservations de ses propres services
        return $user->hasRole('provider')
            && $reservation->service?->user_id === $user->id;
    }
}