<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user with admin role
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Assign view permission for land-jamin module
        $permission = Permission::where('module', 'land-jamin')->where('action', 'view')->first();
        if ($permission) {
            $user->permissions()->attach($permission);
        }

        echo "Test user created with ID: " . $user->id . "\n";
        echo "Assigned permission: " . $permission->name . "\n";
    }
}
