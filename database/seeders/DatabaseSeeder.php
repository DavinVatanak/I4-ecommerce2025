<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ONLY this line. Delete everything else inside this function!
        $this->call(RolePermissionSeeder::class);
    }
}
