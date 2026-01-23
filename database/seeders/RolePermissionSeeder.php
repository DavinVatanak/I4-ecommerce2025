<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Roles
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);

        // 2. Create Manager User
        $manager = User::create([
            'name' => 'Project Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
        ]);
        $manager->assignRole($managerRole);

        // 3. Create Staff User
        $staff = User::create([
            'name' => 'Staff One',
            'email' => 'staff1@example.com',
            'password' => Hash::make('password'),
        ]);
        $staff->assignRole($staffRole);

        // 4. Create a Sample Project (using the manager_id from your migration)
        $project = Project::create([
            'name' => 'Initial TP6 Project',
            'description' => 'This project was created via Seeder',
            'manager_id' => $manager->id, // Links to the manager created above
        ]);

        // 5. Create a Sample Task assigned to Staff
        Task::create([
            'project_id' => $project->id,
            'user_id' => $staff->id, // Assigned to Staff One
            'title' => 'Complete Passport Integration',
            'status' => 'pending'
        ]);

        $this->command->info('Database seeded: Manager and Staff created with Roles and a Project.');
    }
}
