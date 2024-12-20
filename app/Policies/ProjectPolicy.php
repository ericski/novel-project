<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        return $user->id === $project->author_id || $user->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->id === $project->author_id || $user->is_admin;
    }
}
