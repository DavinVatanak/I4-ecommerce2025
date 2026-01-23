<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * View a specific task.
     */
    public function show(Task $task)
    {
        // Matches TaskPolicy@view
        Gate::authorize('view', $task);

        return view('tasks.show', compact('task'));
    }

    /**
     * Update task status (Staff only, assigned to them).
     */
    public function update(Request $request, Task $task)
    {
        // Matches TaskPolicy@updateStatus
        Gate::authorize('updateStatus', $task);

        $task->update([
            'status' => $request->status // e.g., 'completed'
        ]);

        return back()->with('status', 'Task updated successfully!');
    }
}
