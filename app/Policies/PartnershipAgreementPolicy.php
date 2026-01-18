<?php

namespace App\Policies;

use App\Models\PartnershipAgreement;
use App\Models\User;

class PartnershipAgreementPolicy
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
    public function view(User $user, PartnershipAgreement $agreement): bool
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
    public function update(User $user, PartnershipAgreement $agreement): bool
    {
        return $user->isAdmin() || $user->isPastor();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PartnershipAgreement $agreement): bool
    {
        return $user->isAdmin() || $user->isPastor();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PartnershipAgreement $agreement): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PartnershipAgreement $agreement): bool
    {
        return $user->isAdmin();
    }
}
