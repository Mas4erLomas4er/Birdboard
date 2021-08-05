<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return boolean
     */
    public function viewAny (User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Project $project
     * @return boolean
     */
    public function view (User $user, Project $project)
    {
        return $user->is($project->owner) || $project->members->contains($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return boolean
     */
    public function create (User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Project $project
     * @return boolean
     */
    public function update (User $user, Project $project)
    {
        return $user->is($project->owner) || $project->members->contains($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Project $project
     * @return boolean
     */
    public function delete (User $user, Project $project)
    {
        return $user->is($project->owner);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Project $project
     * @return boolean
     */
    public function restore (User $user, Project $project)
    {
        return $user->is($project->owner);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Project $project
     * @return boolean
     */
    public function forceDelete (User $user, Project $project)
    {
        return $user->is($project->owner);
    }

    /**
     * Determine whether the user can invite to the project.
     *
     * @param User $user
     * @param Project $project
     * @return boolean
     */
    public function invite (User $user, Project $project)
    {
        return $user->is($project->owner);
    }
}
