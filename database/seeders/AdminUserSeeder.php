<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
