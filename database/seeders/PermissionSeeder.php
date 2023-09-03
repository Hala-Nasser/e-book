<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission::create(['name' => 'Create-Category', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Read-Categories', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Update-Category', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete-Category', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Category-books', 'guard_name' => 'admin']);

        // Permission::create(['name' => 'Create-Book', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Read-Books', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Update-Book', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete-Book', 'guard_name' => 'admin']);

        // Permission::create(['name' => 'Create-Admin', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Read-Admins', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete-Admin', 'guard_name' => 'admin']);

        // Permission::create(['name' => 'Create-Role', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Read-Roles', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Update-Role', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete-Role', 'guard_name' => 'admin']);

        // Permission::create(['name' => 'Read-Permissions', 'guard_name' => 'admin']);

        // Permission::create(['name' => 'Update-Role-Permissions', 'guard_name' => 'admin']);

        // Permission::create(['name' => 'View-Home', 'guard_name' => 'admin']);
    }
}
