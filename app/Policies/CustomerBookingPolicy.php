<?php

namespace App\Policies;

use App\Models\CustomerBooking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerBookingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasPermissionTo('View CustomerBooking') || $user->hasAnyRole('admin') || $user->hasPermissionTo('CRUD CustomerBooking')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustomerBooking $customerBooking): bool
    {
        if ($user->hasPermissionTo('View CustomerBooking') || $user->hasAnyRole('admin') || $user->hasPermissionTo('CRUD CustomerBooking')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasPermissionTo('Create CustomerBooking') || $user->hasAnyRole('admin') || $user->hasPermissionTo('CRUD CustomerBooking')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomerBooking $customerBooking): bool
    {
        if ($user->hasPermissionTo('Update CustomerBooking') || $user->hasAnyRole('admin') || $user->hasPermissionTo('CRUD CustomerBooking')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomerBooking $customerBooking): bool
    {
        if ($user->hasPermissionTo('Delete CustomerBooking') || $user->hasAnyRole('admin') || $user->hasPermissionTo('CRUD CustomerBooking')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomerBooking $customerBooking): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CustomerBooking $customerBooking): bool
    {
        //
    }
}
