<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $authed, User $user)
    {
        return $authed->id = $user->id || $authed->isSuperAdmin();
    }

    public function block(User $authed, User $user)
    {
        return $authed->isSuperAdmin() && $user->id != $authed->id;
    }

    public function delete(User $authed, User $user)
    {
        return $authed->isSuperAdmin() && $user->id != $authed->id;
    }
}
