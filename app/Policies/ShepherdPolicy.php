<?php

namespace App\Policies;

use App\Models\Shepherd;
use App\Models\User;

class ShepherdPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isPastor();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Shepherd $shepherd): bool
    {
        return $user->isAdmin() || $user->isPastor();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isPastor();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Shepherd $shepherd): bool
    {
        return $user->isAdmin() || $user->isPastor();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Shepherd $shepherd): bool
    {
        return $user->isAdmin() || $user->isPastor();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Shepherd $shepherd): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Shepherd $shepherd): bool
    {
        return $user->isAdmin();
    }
}
