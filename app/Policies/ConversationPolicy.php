<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;

class ConversationPolicy
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
        return $user->hasRole('client') || $user->hasRole('provider');
    }

    public function view(User $user, Conversation $conversation): bool
    {
        return $conversation->client_id === $user->id
            || $conversation->provider_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('client') || $user->hasRole('provider');
    }
}