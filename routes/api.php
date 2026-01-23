<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use App\Models\Project;

// --- Public Routes ---
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('API Token')->accessToken;

    return response()->json([
        'token' => $token,
        'user' => $user->name
    ]);
});

// --- Protected Routes (Passport) ---
Route::middleware('auth:api')->group(function () {

    // 1. Get current user profile
    Route::get('/me', function (Request $request) {
        return response()->json($request->user()->load('roles'));
    });

    // 2. List all projects
    Route::get('/projects', function () {
        return response()->json(Project::all());
    });

    // 3. Create project (Gate Check + Saving)
    Route::post('/projects', function (Request $request) {
        if (!Gate::allows('projects.create')) {
            return response()->json(['message' => 'Forbidden: Manager role required'], 403);
        }

        $project = Project::create($request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]));

        return response()->json([
            'message' => 'Project created successfully',
            'data' => $project
        ], 201);
    });

    // 4. Update Task Status (Policy Check)
    Route::patch('/tasks/{task}/status', function (Request $request, Task $task) {
        if ($request->user()->cannot('updateStatus', $task)) {
            return response()->json(['message' => 'Forbidden: Task not assigned to you'], 403);
        }

        $task->update(['status' => 'completed']);
        return response()->json(['message' => 'Task marked as completed']);
    });
});
