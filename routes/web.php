<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController; // Ensure this is imported
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard is accessible to everyone logged in
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes (Existing)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- PART 3: PROTECTED PROJECT ROUTES ---

    // 1. Only Managers and Admins can create projects
    Route::get('/projects/create', [ProjectController::class, 'create'])
        ->middleware('can:projects.create')
        ->name('projects.create');

    Route::post('/projects', [ProjectController::class, 'store'])
        ->middleware('can:projects.create')
        ->name('projects.store');

    // 2. Staff, Managers, and Admins can see the list of projects
    Route::get('/projects', [ProjectController::class, 'index'])
        ->name('projects.index');

    // Task routes using the new TaskController
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update_status');
});

require __DIR__.'/auth.php';
