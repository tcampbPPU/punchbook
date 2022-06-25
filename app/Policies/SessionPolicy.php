<?php

namespace App\Policies;

use acidjazz\Humble\Models\Session;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SessionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Session  $session
     * @return bool
     */
    public function delete(User $user, Session $session): bool
    {
        return $user->id === $session->user_id;
    }
}
