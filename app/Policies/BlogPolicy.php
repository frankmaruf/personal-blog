<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BlogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */

    public function viewAny(?User $user)
    {
        // if($user->hasAnyRole(["super-admin","admin"])){
        //     return true;
        // }
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(?User $user, Blog $post)
    {
        if ($post->status) {
            return true;
        }
        if (optional($user) === null) {
            return false;
        }
        if (optional($user)->hasAnyRole(["super-admin", "admin"])) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('Create Blog') ? Response::allow() : Response::deny("You don't haver permission");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Blog $blog)
    {
        if ($user->can('Update Blog')) {
            return $user->id == $blog->user_id ? Response::allow()
                : Response::deny("You don't own or have enough permission for this post.");
        }
        if ($user->hasAnyRole(["super-admin", "admin"])) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Blog $blog)
    {
        if ($user->can('Delete Blog')) {
            return $user->id == $blog->user_id ? Response::allow()
                : Response::deny("You don't own or have enough permission for this post.");
        }

        if ($user->hasAnyRole(["super-admin", "admin"])) {
            return true;
        }
        // return $user->id === $blog->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Blog $blog)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Blog $blog)
    {
        //
    }
}
