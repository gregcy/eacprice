<?php

namespace App\Policies;

use App\Models\Adjustment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdjustmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Adjustment $adjustment): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Adjustment $adjustment): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Adjustment $adjustment): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Adjustment $adjustment): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Adjustment $adjustment): bool
    {
        return Auth::check();
    }
}
