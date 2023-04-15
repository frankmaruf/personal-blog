<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Response;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Project $project)
    {
        if ($project->status) {
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
        
        return $user->can('Create Project') || $user->hasAnyRole(["super-admin", "admin"]) ? Response::allow() : Response::deny("You don't haver permission");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Project $project)
    {
        if ($user->can('Update Project')) {
            return $user->id == $project->user_id || $user->hasAnyRole(["super-admin", "admin"]) ? Response::allow()
                : Response::deny("You don't own or have enough permission for this project.");
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Project $project)
    {
        if ($user->can('Delete Project')) {
            foreach ($project->users as $user_p) {
                return $user->id == $user_p->pivot->is_manager || $user->hasAnyRole(["super-admin", "admin"]) ? Response::allow()
                : Response::deny("You don't own or have enough permission for this Project.");
            }
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Project $project)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Project $project)
    {
        //
    }
}
