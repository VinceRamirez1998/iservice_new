<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasPermissionTo('View Service') || $user->hasAnyRole('admin') || $user->hasPermissionTo('CRUD Service')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Service $service): bool
    {
        if ($user->hasPermissionTo('View Service') || $user->hasAnyRole('admin') || $user->hasPermissionTo('CRUD Service')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasPermissionTo('Create Service') || $user->hasAnyRole('admin') || $user->hasPermissionTo('CRUD Service')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Service $service): bool
    {
        if ($user->hasPermissionTo('Update Service') || $user->hasAnyRole('admin') || $user->hasPermissionTo('CRUD Service')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Service $service): bool
    {
        if ($user->hasPermissionTo('Delete Service') || $user->hasAnyRole('admin') || $user->hasPermissionTo('CRUD Service')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Service $service): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Service $service): bool
    {
        //
    }
}
