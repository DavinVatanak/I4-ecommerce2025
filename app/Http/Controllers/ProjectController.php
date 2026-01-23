<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Show the form
    public function create()
    {
        // "Abort if the user CANNOT create projects"
        abort_unless(auth()->user()->can('projects.create'), 403);

        return view('projects.create');
    }

    // Save the project
    public function store(Request $request)
    {
        // Double-check security here (prevents Postman/API bypass attempts)
        abort_unless(auth()->user()->can('projects.create'), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        auth()->user()->projects()->create($validated);

        return redirect()->route('dashboard')->with('status', 'Project initialized successfully!');
    }
}
