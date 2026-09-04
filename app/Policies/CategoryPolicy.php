<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
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
        return $user->hasPermission('view-categories');
    }

    public function view(User $user, Category $category): bool
    {
        return $user->hasPermission('view-categories');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('create-categories');
    }

    public function update(User $user, Category $category): bool
    {
        return $user->hasPermission('edit-categories');
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->hasPermission('delete-categories');
    }
}