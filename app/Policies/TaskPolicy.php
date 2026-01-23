<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function updateStatus(User $user, Task $task): bool
    {
        // Logic: current user ID must match the task's user_id
        return $user->id === $task->user_id;
    }
}
