<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test admin user and authenticate
        $this->adminUser = User::factory()->create([
            'role' => 'admin'
        ]);
        
        $this->actingAs($this->adminUser);
    }

    // Management User CRUD tests
    public function test_it_can_create_a_management_user()
    {
        $userData = [
            'name' => 'Test Management User',
            'username' => 'testmanager',
            'email' => 'testmanager@example.com',
            'password' => 'password123',
            'contact' => '1234567890',
            'dob' => '1990-01-01',
            'role' => 'admin',
            'status' => 'active',
        ];

        $response = $this->post('/admin/users/management', $userData);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'User created successfully']);
        $this->assertDatabaseHas('users', [
            'email' => 'testmanager@example.com',
            'role' => 'admin'
        ]);
    }

    public function test_it_can_update_a_management_user()
    {
        $user = User::factory()->create([
            'role' => 'admin',
            'name' => 'Original Name',
            'username' => 'originaluser',
            'email' => 'original@example.com'
        ]);

        $updatedData = [
            'name' => 'Updated Name',
            'username' => $user->username, // Keep original username
            'email' => 'updated@example.com',
            'contact' => '0987654321',
            'dob' => '1995-05-05',
            'role' => 'admin',
            'status' => 'inactive',
        ];

        $response = $this->put("/admin/users/management/{$user->id}", $updatedData);

        $response->assertStatus(200); // AJAX requests return 200, not 302
        $response->assertJson(['message' => 'User updated successfully']);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'status' => 'inactive'
        ]);
    }

    public function test_it_can_delete_a_management_user()
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->delete("/admin/users/management/{$user->id}");

        $response->assertStatus(200); // AJAX requests return 200
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_it_can_toggle_management_user_status()
    {
        $user = User::factory()->create([
            'role' => 'admin',
            'status' => 'active'
        ]);

        $response = $this->patch("/admin/users/management/{$user->id}/toggle-status");

        $response->assertStatus(200); // AJAX requests return 200
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => 'inactive' // Should toggle from active to inactive
        ]);
    }

    public function test_it_can_retrieve_management_users_index()
    {
        $response = $this->get('/admin/users/management');

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.management');
    }

    // Regular User CRUD tests
    public function test_it_can_create_a_regular_user()
    {
        $userData = [
            'name' => 'Test Regular User',
            'username' => 'testregular',
            'email' => 'testregular@example.com',
            'password' => 'password123',
            'contact' => '1234567890',
            'dob' => '1990-01-01',
            'role' => 'user',
            'status' => 'active',
        ];

        $response = $this->post('/admin/users/regular', $userData);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'User created successfully']);
        $this->assertDatabaseHas('users', [
            'email' => 'testregular@example.com',
            'role' => 'user'
        ]);
    }

    public function test_it_can_update_a_regular_user()
    {
        $user = User::factory()->create([
            'role' => 'user',
            'name' => 'Original Regular User',
            'username' => 'originalregularuser',
            'email' => 'originalregular@example.com'
        ]);

        $updatedData = [
            'name' => 'Updated Regular User',
            'username' => $user->username, // Keep original username
            'email' => 'updatedregular@example.com',
            'contact' => '0987654321',
            'dob' => '1995-05-05',
            'role' => 'user',
            'status' => 'inactive',
        ];

        $response = $this->put("/admin/users/regular/{$user->id}", $updatedData);

        $response->assertStatus(200); // AJAX requests return 200, not 302
        $response->assertJson(['message' => 'User updated successfully']);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Regular User',
            'email' => 'updatedregular@example.com',
            'status' => 'inactive'
        ]);
    }

    public function test_it_can_delete_a_regular_user()
    {
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        $response = $this->delete("/admin/users/regular/{$user->id}");

        $response->assertStatus(200); // AJAX requests return 200
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_it_can_toggle_regular_user_status()
    {
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active'
        ]);

        $response = $this->patch("/admin/users/regular/{$user->id}/toggle-status");

        $response->assertStatus(200); // AJAX requests return 200
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => 'inactive' // Should toggle from active to inactive
        ]);
    }

    public function test_it_can_retrieve_regular_users_index()
    {
        $response = $this->get('/admin/users/regular');

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.regular');
    }
}