<?php

namespace App\Policies;

use App\Models\PublishingHouse;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PublishingHousePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PublishingHouse  $publishingHouse
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, PublishingHouse $publishingHouse)
    {
        return $publishingHouse->user->id === $user->id || $user->grantedAdminRoles();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PublishingHouse  $publishingHouse
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, PublishingHouse $publishingHouse)
    {
        return $publishingHouse->user->id === $user->id || $user->grantedAdminRoles();
    }
}
