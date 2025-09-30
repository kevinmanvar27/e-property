<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\Country;
use App\Models\State;
use App\Models\District;

class HousePropertyTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user
        $this->adminUser = User::factory()->admin()->create();
    }

    // House CRUD tests
    public function test_it_can_create_a_house_property()
    {
        $country = Country::create([
            'country_name' => 'India',
            'country_code' => 'IN'
        ]);

        $state = State::create([
            'state_title' => 'Gujarat',
            'country_id' => $country->country_id
        ]);

        $district = District::create([
            'district_title' => 'Ahmedabad',
            'state_id' => $state->state_id
        ]);

        $propertyData = [
            'owner_name' => 'John Doe',
            'first_line' => '123 Main Street',
            'second_line' => 'House Area',
            'village' => 'Test Village',
            'district_id' => $district->districtid,
            'state_id' => $state->state_id,
            'pincode' => '123456',
            'country_id' => $country->country_id,
            'property_type' => 'house',
            'bhk' => 3,
            'is_apartment' => 'yes',
            'apartment_floor' => 5,
            'is_tenament' => 'no',
            'size' => 1200.50,
        ];

        $response = $this->actingAs($this->adminUser)
                         ->post('/admin/house', $propertyData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('properties', [
            'owner_name' => 'John Doe',
            'property_type' => 'house',
            'bhk' => 3,
            'is_apartment' => 'yes',
            'apartment_floor' => 5,
            'is_tenament' => 'no',
        ]);
    }

    public function test_it_can_update_a_house_property()
    {
        $country = Country::create([
            'country_name' => 'India',
            'country_code' => 'IN'
        ]);

        $state = State::create([
            'state_title' => 'Gujarat',
            'country_id' => $country->country_id
        ]);

        $district = District::create([
            'district_title' => 'Ahmedabad',
            'state_id' => $state->state_id
        ]);

        $property = Property::create([
            'owner_name' => 'John Doe',
            'first_line' => '123 Main Street',
            'second_line' => 'House Area',
            'village' => 'Test Village',
            'district_id' => $district->districtid,
            'state_id' => $state->state_id,
            'pincode' => '123456',
            'country_id' => $country->country_id,
            'property_type' => 'house',
            'bhk' => 3,
            'is_apartment' => 'yes',
            'apartment_floor' => 5,
            'is_tenament' => 'no',
            'size' => 1200.50,
        ]);

        $updatedData = [
            'owner_name' => 'Jane Smith',
            'first_line' => '456 New Street',
            'second_line' => 'Updated House Area',
            'village' => 'Updated Village',
            'district_id' => $district->districtid,
            'state_id' => $state->state_id,
            'pincode' => '654321',
            'country_id' => $country->country_id,
            'property_type' => 'house',
            'bhk' => 4,
            'is_apartment' => 'no',
            'is_tenament' => 'yes',
            'tenament_floors' => 3,
            'size' => 1500.75,
        ];

        $response = $this->actingAs($this->adminUser)
                         ->put("/admin/house/{$property->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('properties', [
            'owner_name' => 'Jane Smith',
            'property_type' => 'house',
            'bhk' => 4,
            'is_apartment' => 'no',
            'is_tenament' => 'yes',
            'tenament_floors' => 3,
        ]);
    }

    public function test_it_can_delete_a_house_property()
    {
        $country = Country::create([
            'country_name' => 'India',
            'country_code' => 'IN'
        ]);

        $state = State::create([
            'state_title' => 'Gujarat',
            'country_id' => $country->country_id
        ]);

        $district = District::create([
            'district_title' => 'Ahmedabad',
            'state_id' => $state->state_id
        ]);

        $property = Property::create([
            'owner_name' => 'John Doe',
            'first_line' => '123 Main Street',
            'village' => 'Test Village',
            'district_id' => $district->districtid,
            'state_id' => $state->state_id,
            'pincode' => '123456',
            'country_id' => $country->country_id,
            'property_type' => 'house',
        ]);

        $response = $this->actingAs($this->adminUser)
                         ->delete("/admin/house/{$property->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
    }

    public function test_it_can_retrieve_house_index()
    {
        $response = $this->actingAs($this->adminUser)
                         ->get('/admin/house');

        $response->assertStatus(200);
        $response->assertViewIs('admin.house.index');
    }
}