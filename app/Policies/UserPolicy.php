<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super-admin') || $user->hasRole('admin');
    }

    public function view(User $user, User $model): bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasRole('admin')) {
            return !$model->hasRole('super-admin');
        }

        return $user->is($model);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super-admin') || $user->hasRole('admin');
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasRole('super-admin');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
