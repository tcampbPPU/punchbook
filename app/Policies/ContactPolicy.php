<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return (bool) $user;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User  $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return (bool) $user;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User  $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return (bool) $user;
    }
}
