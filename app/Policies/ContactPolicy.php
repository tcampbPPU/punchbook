<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return (bool) $user;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User  $user
     * @param Contact  $contact
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Contact $contact)
    {
        return (bool) $user;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User  $user
     * @param Contact  $contact
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Contact $contact)
    {
        return (bool) $user;
    }
}
