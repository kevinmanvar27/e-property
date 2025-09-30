<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\Country;
use App\Models\State;
use App\Models\District;
use App\Models\City;

class PropertyCRUDTest extends TestCase
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

    // Land/Jamin CRUD tests
    public function test_it_can_create_a_land_jamin_property()
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
            'second_line' => 'Apartment 4B',
            'village' => 'Test Village',
            'district_id' => $district->districtid,
            'state_id' => $state->state_id,
            'pincode' => '123456',
            'country_id' => $country->country_id,
            'vavetar' => 'Yes',
            'any_issue' => 'No',
            'electric_poll' => 'Yes',
            'electric_poll_count' => 2,
            'family_issue' => 'No',
            'road_distance' => 100.50,
            'additional_notes' => 'Test notes',
            'property_type' => 'land_jamin',
        ];

        $response = $this->post('/admin/land-jamin', $propertyData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('properties', [
            'owner_name' => 'John Doe',
            'property_type' => 'land_jamin'
        ]);
    }

    public function test_it_can_update_a_land_jamin_property()
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
            'second_line' => 'Apartment 4B',
            'village' => 'Test Village',
            'district_id' => $district->districtid,
            'state_id' => $state->state_id,
            'pincode' => '123456',
            'country_id' => $country->country_id,
            'vavetar' => 'Yes',
            'any_issue' => 'No',
            'electric_poll' => 'Yes',
            'electric_poll_count' => 2,
            'family_issue' => 'No',
            'road_distance' => 100.50,
            'additional_notes' => 'Test notes',
            'property_type' => 'land_jamin',
        ]);

        $updatedData = [
            'owner_name' => 'Jane Smith',
            'first_line' => '456 New Street',
            'second_line' => 'Suite 5C',
            'village' => 'Updated Village',
            'district_id' => $district->districtid,
            'state_id' => $state->state_id,
            'pincode' => '654321',
            'country_id' => $country->country_id,
            'vavetar' => 'No',
            'any_issue' => 'Yes',
            'electric_poll' => 'No',
            'electric_poll_count' => 1,
            'family_issue' => 'Yes',
            'road_distance' => 200.75,
            'additional_notes' => 'Updated notes',
            'property_type' => 'land_jamin',
        ];

        $response = $this->put("/admin/land-jamin/{$property->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('properties', [
            'owner_name' => 'Jane Smith',
            'property_type' => 'land_jamin'
        ]);
    }

    public function test_it_can_delete_a_land_jamin_property()
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
            'property_type' => 'land_jamin',
        ]);

        $response = $this->delete("/admin/land-jamin/{$property->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
    }

    public function test_it_can_retrieve_land_jamin_index()
    {
        $response = $this->get('/admin/land-jamin');

        $response->assertStatus(200);
        $response->assertViewIs('admin.land-jamin.index');
    }

    // Plot CRUD tests
    public function test_it_can_create_a_plot_property()
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
            'second_line' => 'Plot Area',
            'village' => 'Test Village',
            'district_id' => $district->districtid,
            'state_id' => $state->state_id,
            'pincode' => '123456',
            'country_id' => $country->country_id,
            'property_type' => 'plot',
        ];

        $response = $this->post('/admin/plot', $propertyData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('properties', [
            'owner_name' => 'John Doe',
            'property_type' => 'plot'
        ]);
    }

    public function test_it_can_update_a_plot_property()
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
            'second_line' => 'Plot Area',
            'village' => 'Test Village',
            'district_id' => $district->districtid,
            'state_id' => $state->state_id,
            'pincode' => '123456',
            'country_id' => $country->country_id,
            'property_type' => 'plot',
        ]);

        $updatedData = [
            'owner_name' => 'Jane Smith',
            'first_line' => '456 New Street',
            'second_line' => 'Updated Plot Area',
            'village' => 'Updated Village',
            'district_id' => $district->districtid,
            'state_id' => $state->state_id,
            'pincode' => '654321',
            'country_id' => $country->country_id,
            'property_type' => 'plot',
        ];

        $response = $this->put("/admin/plot/{$property->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('properties', [
            'owner_name' => 'Jane Smith',
            'property_type' => 'plot'
        ]);
    }

    public function test_it_can_delete_a_plot_property()
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
            'property_type' => 'plot',
        ]);

        $response = $this->delete("/admin/plot/{$property->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
    }

    public function test_it_can_retrieve_plot_index()
    {
        $response = $this->get('/admin/plot');

        $response->assertStatus(200);
        $response->assertViewIs('admin.plot.index');
    }

    // Shad CRUD tests
    public function test_it_can_create_a_shad_property()
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
            'second_line' => 'Shad Area',
            'village' => 'Test Village',
            'district_id' => $district->districtid,
            'state_id' => $state->state_id,
            'pincode' => '123456',
            'country_id' => $country->country_id,
            'property_type' => 'shad',
            'size' => 150.50,
        ];

        $response = $this->post('/admin/shad', $propertyData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('properties', [
            'owner_name' => 'John Doe',
            'property_type' => 'shad'
        ]);
    }

    public function test_it_can_update_a_shad_property()
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
            'second_line' => 'Shad Area',
            'village' => 'Test Village',
            'district_id' => $district->districtid,
            'state_id' => $state->state_id,
            'pincode' => '123456',
            'country_id' => $country->country_id,
            'property_type' => 'shad',
            'size' => 150.50,
        ]);

        $updatedData = [
            'owner_name' => 'Jane Smith',
            'first_line' => '456 New Street',
            'second_line' => 'Updated Shad Area',
            'village' => 'Updated Village',
            'district_id' => $district->districtid,
            'state_id' => $state->state_id,
            'pincode' => '654321',
            'country_id' => $country->country_id,
            'property_type' => 'shad',
            'size' => 200.75,
        ];

        $response = $this->put("/admin/shad/{$property->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('properties', [
            'owner_name' => 'Jane Smith',
            'property_type' => 'shad'
        ]);
    }

    public function test_it_can_delete_a_shad_property()
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
            'property_type' => 'shad',
        ]);

        $response = $this->delete("/admin/shad/{$property->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
    }

    public function test_it_can_retrieve_shad_index()
    {
        $response = $this->get('/admin/shad');

        $response->assertStatus(200);
        $response->assertViewIs('admin.shad.index');
    }
}