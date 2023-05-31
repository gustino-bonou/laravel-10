<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Models\Group;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return ($user->id === $task->user_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        
        return ($task->user_id === $user->id || $task->users->contains($user));
    }

    public function updateGroupTask(User $user, Task $task): bool
    {  
        return ($task->user_id === $user->id);
    }




    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        //
    }

    public function marqueToFinish(User $user, Task $task)
    {
        return ($task->user_id === $user->id) || ($task->group_id !== null &&  $task->group->users->contains($user->id));
    }
    public function marqueToBegin(User $user, Task $task)
    {
        return ($task->user_id === $user->id) || ($task->group_id !== null &&  $task->group->users->contains($user->id));
    }
}
