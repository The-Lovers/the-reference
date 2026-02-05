<?php

namespace App\Policies;

use App\Models\Domains;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DomainsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Domains $domains): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->roles->contains('name', 'super-admin') || $user->roles->contains('name', 'admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Domains $domains): bool
    {
        return $user->roles->contains('name', 'super-admin') || $user->roles->contains('name', 'admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Domains $domains): bool
    {
        return $user->roles->contains('name', 'super-admin') || $user->roles->contains('name', 'admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Domains $domains): bool
    {
        return $user->roles->contains('name', 'super-admin') || $user->roles->contains('name', 'admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Domains $domains): bool
    {
        return $user->roles->contains('name', 'super-admin') || $user->roles->contains('name', 'admin');
    }
}
