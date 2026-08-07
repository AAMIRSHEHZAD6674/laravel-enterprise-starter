<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $superAdmin = Role::findOrCreate('Super Admin');
        $admin = Role::findOrCreate('Admin');
        $manager = Role::findOrCreate('Manager');
        $user = Role::findOrCreate('User');

        // Create Permissions
        $permissions = [
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'activity_logs.view',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Assign all permissions to Super Admin
        $superAdmin->givePermissionTo(Permission::all());

        // Assign selected permissions to Admin
        $admin->givePermissionTo([
            'users.view',
            'users.create',
            'users.edit',
            'activity_logs.view',
        ]);

        // Manager permissions
        $manager->givePermissionTo([
            'users.view',
        ]);
    }
}