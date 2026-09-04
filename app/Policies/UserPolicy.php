<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Admin has full access.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    /**
     * Display users list.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view-users');
    }

    /**
     * Display a specific user.
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasPermission('view-users');
    }

    /**
     * Create a user.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('manage-users');
    }

    /**
     * Update a user.
     */
    public function update(User $user, User $model): bool
    {
        return $user->hasPermission('manage-users');
    }

    /**
     * Delete a user.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasPermission('manage-users')
            && $user->id !== $model->id;
    }
}