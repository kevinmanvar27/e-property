<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Amenity;
use App\Models\LandType;

class MasterDataTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test user and authenticate
        $user = User::factory()->create([
            'role' => 'admin'
        ]);
        
        $this->actingAs($user);
    }

    // Amenity CRUD tests
    public function test_it_can_create_an_amenity()
    {
        $amenityData = [
            'name' => 'Swimming Pool',
            'description' => 'Swimming pool with lifeguard',
        ];

        $response = $this->post('/admin/amenities', $amenityData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('amenities', $amenityData);
    }

    public function test_it_can_update_an_amenity()
    {
        $amenity = Amenity::create([
            'name' => 'Swimming Pool',
            'description' => 'Swimming pool with lifeguard',
        ]);

        $updatedData = [
            'name' => 'Updated Swimming Pool',
            'description' => 'Updated swimming pool with lifeguard',
        ];

        $response = $this->put("/admin/amenities/{$amenity->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('amenities', $updatedData);
    }

    public function test_it_can_delete_an_amenity()
    {
        $amenity = Amenity::create([
            'name' => 'Swimming Pool',
            'description' => 'Swimming pool with lifeguard',
        ]);

        $response = $this->delete("/admin/amenities/{$amenity->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseMissing('amenities', ['id' => $amenity->id]);
    }

    public function test_it_can_retrieve_amenities_index()
    {
        $response = $this->get('/admin/amenities');

        $response->assertStatus(200);
        $response->assertViewIs('admin.master-data.amenities.index');
    }

    // Land Type CRUD tests
    public function test_it_can_create_a_land_type()
    {
        $landTypeData = [
            'name' => 'Agricultural Land',
            'description' => 'Land suitable for agriculture',
        ];

        $response = $this->post('/admin/land-types', $landTypeData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('land_types', $landTypeData);
    }

    public function test_it_can_update_a_land_type()
    {
        $landType = LandType::create([
            'name' => 'Agricultural Land',
            'description' => 'Land suitable for agriculture',
        ]);

        $updatedData = [
            'name' => 'Updated Agricultural Land',
            'description' => 'Updated land suitable for agriculture',
        ];

        $response = $this->put("/admin/land-types/{$landType->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('land_types', $updatedData);
    }

    public function test_it_can_delete_a_land_type()
    {
        $landType = LandType::create([
            'name' => 'Agricultural Land',
            'description' => 'Land suitable for agriculture',
        ]);

        $response = $this->delete("/admin/land-types/{$landType->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseMissing('land_types', ['id' => $landType->id]);
    }

    public function test_it_can_retrieve_land_types_index()
    {
        $response = $this->get('/admin/land-types');

        $response->assertStatus(200);
        $response->assertViewIs('admin.master-data.land-types.index');
    }
}