<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class WorkingRouteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_access_shop_routes()
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
        
        // Test shop route
        $response = $this->get('/admin/shop');
        $response->assertStatus(200);
    }
}