<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class HouseRouteTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user
        $this->adminUser = User::factory()->admin()->create();
    }

    /** @test */
    public function house_routes_exist()
    {
        // Test that the house routes are defined and return the correct status codes
        
        // Test index route
        $response = $this->actingAs($this->adminUser)
                         ->get('/admin/house');
        $response->assertStatus(200);
        
        // Test create route
        $response = $this->actingAs($this->adminUser)
                         ->get('/admin/house/create');
        $response->assertStatus(200);
    }
}