<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;


    public function update(User $user, Category $category)
    {
        return $user->id = $category->user->id || $user->grantedAdminRoles();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user,  Category $category)
    {
        return $user->id = $category->user->id || $user->grantedAdminRoles();
    }
}
