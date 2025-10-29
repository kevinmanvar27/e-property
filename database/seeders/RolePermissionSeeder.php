<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default roles
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'description' => 'Administrator with full access',
            'status' => 'active',
        ]);

        $managerRole = Role::firstOrCreate([
            'name' => 'manager',
            'description' => 'Manager with limited access',
            'status' => 'active',
        ]);

        $staffRole = Role::firstOrCreate([
            'name' => 'staff',
            'description' => 'Staff member with basic access',
            'status' => 'active',
        ]);

        // Create default permissions
        $permissions = [
            // Land/Jamin permissions
            ['name' => 'land-jamin-view', 'module' => 'land-jamin', 'action' => 'view'],
            ['name' => 'land-jamin-create', 'module' => 'land-jamin', 'action' => 'create'],
            ['name' => 'land-jamin-update', 'module' => 'land-jamin', 'action' => 'update'],
            ['name' => 'land-jamin-delete', 'module' => 'land-jamin', 'action' => 'delete'],

            // Plot permissions
            ['name' => 'plot-view', 'module' => 'plot', 'action' => 'view'],
            ['name' => 'plot-create', 'module' => 'plot', 'action' => 'create'],
            ['name' => 'plot-update', 'module' => 'plot', 'action' => 'update'],
            ['name' => 'plot-delete', 'module' => 'plot', 'action' => 'delete'],

            // Shad permissions
            ['name' => 'shad-view', 'module' => 'shad', 'action' => 'view'],
            ['name' => 'shad-create', 'module' => 'shad', 'action' => 'create'],
            ['name' => 'shad-update', 'module' => 'shad', 'action' => 'update'],
            ['name' => 'shad-delete', 'module' => 'shad', 'action' => 'delete'],

            // Shop permissions
            ['name' => 'shop-view', 'module' => 'shop', 'action' => 'view'],
            ['name' => 'shop-create', 'module' => 'shop', 'action' => 'create'],
            ['name' => 'shop-update', 'module' => 'shop', 'action' => 'update'],
            ['name' => 'shop-delete', 'module' => 'shop', 'action' => 'delete'],

            // House permissions
            ['name' => 'house-view', 'module' => 'house', 'action' => 'view'],
            ['name' => 'house-create', 'module' => 'house', 'action' => 'create'],
            ['name' => 'house-update', 'module' => 'house', 'action' => 'update'],
            ['name' => 'house-delete', 'module' => 'house', 'action' => 'delete'],

            // User management permissions
            ['name' => 'user-view', 'module' => 'user', 'action' => 'view'],
            ['name' => 'user-create', 'module' => 'user', 'action' => 'create'],
            ['name' => 'user-update', 'module' => 'user', 'action' => 'update'],
            ['name' => 'user-delete', 'module' => 'user', 'action' => 'delete'],

            // Role management permissions
            ['name' => 'role-view', 'module' => 'role', 'action' => 'view'],
            ['name' => 'role-create', 'module' => 'role', 'action' => 'create'],
            ['name' => 'role-update', 'module' => 'role', 'action' => 'update'],
            ['name' => 'role-delete', 'module' => 'role', 'action' => 'delete'],
            
            // Contact Us permissions
            ['name' => 'contact-us-view', 'module' => 'contact-us', 'action' => 'view'],
            ['name' => 'contact-us-update', 'module' => 'contact-us', 'action' => 'update'],
        ];

        // Create permissions
        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate(
                ['name' => $permissionData['name']],
                $permissionData
            );
        }

        // Assign default permissions to roles
        // Admin gets all permissions
        $allPermissions = Permission::all();
        $adminRole->permissions()->sync($allPermissions->pluck('id'));

        // Manager gets most permissions except user/role management
        $managerPermissions = Permission::whereNotIn('module', ['user', 'role'])->get();
        $managerRole->permissions()->sync($managerPermissions->pluck('id'));

        // Staff gets only view permissions
        $staffPermissions = Permission::where('action', 'view')->get();
        $staffRole->permissions()->sync($staffPermissions->pluck('id'));
    }
}
