<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the admin user with provided credentials
        User::updateOrCreate([
            'email' => 'rektech.uk@gmail.com',
        ], [
            'name' => 'Admin User',
            'username' => 'admin',
            'password' => bcrypt('RekTech@27'),
            'role' => 'super_admin',
            'status' => 'active',
        ]);
    }
}