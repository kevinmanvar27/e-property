<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_access_house_routes()
    {
        // Create an admin user
        $user = User::factory()->create([
            'role' => 'admin',
            'status' => 'active'
        ]);
        
        // Test authentication
        $this->actingAs($user);
        
        // Check if user is authenticated
        $this->assertTrue(auth()->check());
        
        // Check user role
        $this->assertEquals('admin', auth()->user()->role);
        
        // Test house route
        $response = $this->get('/admin/house');
        $response->assertStatus(200);
    }
}