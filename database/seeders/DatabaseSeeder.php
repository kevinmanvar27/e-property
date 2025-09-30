<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a super admin user
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'role' => 'super_admin',
            'status' => 'active',
        ]);
        
        // Create a regular user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
            'status' => 'active',
        ]);
        
        // Run all the seeders
        $this->call([
            LocationSeeder::class,
            AdminUserSeeder::class,
            SettingsSeeder::class,
        ]);
    }
}