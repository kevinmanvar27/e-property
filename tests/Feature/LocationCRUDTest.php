<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Country;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\User;

class LocationCRUDTest extends TestCase
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

    // Country CRUD tests
    public function test_it_can_create_a_country()
    {
        $countryData = [
            'country_name' => 'Test Country',
            'country_code' => 'TC',
            'description' => 'A test country',
        ];

        $response = $this->post('/admin/countries', $countryData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('countries', $countryData);
    }

    public function test_it_can_update_a_country()
    {
        $country = Country::create([
            'country_name' => 'Test Country',
            'country_code' => 'TC',
            'description' => 'A test country',
        ]);

        $updatedData = [
            'country_name' => 'Updated Test Country',
            'country_code' => 'UTC',
            'description' => 'An updated test country',
        ];

        $response = $this->put("/admin/countries/{$country->country_id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('countries', $updatedData);
    }

    public function test_it_can_delete_a_country()
    {
        $country = Country::create([
            'country_name' => 'Test Country',
            'country_code' => 'TC',
            'description' => 'A test country',
        ]);

        $response = $this->delete("/admin/countries/{$country->country_id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseMissing('countries', ['country_id' => $country->country_id]);
    }

    public function test_it_can_retrieve_countries_index()
    {
        $response = $this->get('/admin/countries');

        $response->assertStatus(200);
        $response->assertViewIs('admin.master-data.countries.index');
    }

    // State CRUD tests
    public function test_it_can_create_a_state()
    {
        $country = Country::create([
            'country_name' => 'Test Country',
            'country_code' => 'TC',
            'description' => 'A test country',
        ]);

        $stateData = [
            'state_title' => 'Test State',
            'country_id' => $country->country_id,
            'state_description' => 'A test state',
        ];

        $response = $this->post('/admin/states', $stateData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('state', $stateData);
    }

    public function test_it_can_update_a_state()
    {
        $country = Country::create([
            'country_name' => 'Test Country',
            'country_code' => 'TC',
            'description' => 'A test country',
        ]);

        $state = State::create([
            'state_title' => 'Test State',
            'country_id' => $country->country_id,
            'state_description' => 'A test state',
        ]);

        $updatedData = [
            'state_title' => 'Updated Test State',
            'country_id' => $country->country_id,
            'state_description' => 'An updated test state',
        ];

        $response = $this->put("/admin/states/{$state->state_id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('state', $updatedData);
    }

    public function test_it_can_delete_a_state()
    {
        $country = Country::create([
            'country_name' => 'Test Country',
            'country_code' => 'TC',
            'description' => 'A test country',
        ]);

        $state = State::create([
            'state_title' => 'Test State',
            'country_id' => $country->country_id,
            'state_description' => 'A test state',
        ]);

        $response = $this->delete("/admin/states/{$state->state_id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseMissing('state', ['state_id' => $state->state_id]);
    }

    public function test_it_can_retrieve_states_index()
    {
        $response = $this->get('/admin/states');

        $response->assertStatus(200);
        $response->assertViewIs('admin.master-data.states.index');
    }

    // District CRUD tests
    public function test_it_can_create_a_district()
    {
        $country = Country::create([
            'country_name' => 'Test Country',
            'country_code' => 'TC',
            'description' => 'A test country',
        ]);

        $state = State::create([
            'state_title' => 'Test State',
            'country_id' => $country->country_id,
            'state_description' => 'A test state',
        ]);

        $districtData = [
            'district_title' => 'Test District',
            'state_id' => $state->state_id,
            'district_description' => 'A test district',
        ];

        $response = $this->post('/admin/districts', $districtData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('district', $districtData);
    }

    public function test_it_can_update_a_district()
    {
        $country = Country::create([
            'country_name' => 'Test Country',
            'country_code' => 'TC',
            'description' => 'A test country',
        ]);

        $state = State::create([
            'state_title' => 'Test State',
            'country_id' => $country->country_id,
            'state_description' => 'A test state',
        ]);

        $district = District::create([
            'district_title' => 'Test District',
            'state_id' => $state->state_id,
            'district_description' => 'A test district',
        ]);

        $updatedData = [
            'district_title' => 'Updated Test District',
            'state_id' => $state->state_id,
            'district_description' => 'An updated test district',
        ];

        $response = $this->put("/admin/districts/{$district->districtid}", $updatedData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('district', $updatedData);
    }

    public function test_it_can_delete_a_district()
    {
        $country = Country::create([
            'country_name' => 'Test Country',
            'country_code' => 'TC',
            'description' => 'A test country',
        ]);

        $state = State::create([
            'state_title' => 'Test State',
            'country_id' => $country->country_id,
            'state_description' => 'A test state',
        ]);

        $district = District::create([
            'district_title' => 'Test District',
            'state_id' => $state->state_id,
            'district_description' => 'A test district',
        ]);

        $response = $this->delete("/admin/districts/{$district->districtid}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseMissing('district', ['districtid' => $district->districtid]);
    }

    public function test_it_can_retrieve_districts_index()
    {
        $response = $this->get('/admin/districts');

        $response->assertStatus(200);
        $response->assertViewIs('admin.master-data.districts.index');
    }

    // City CRUD tests
    public function test_it_can_create_a_city()
    {
        $country = Country::create([
            'country_name' => 'Test Country',
            'country_code' => 'TC',
            'description' => 'A test country',
        ]);

        $state = State::create([
            'state_title' => 'Test State',
            'country_id' => $country->country_id,
            'state_description' => 'A test state',
        ]);

        $district = District::create([
            'district_title' => 'Test District',
            'state_id' => $state->state_id,
            'district_description' => 'A test district',
        ]);

        $cityData = [
            'name' => 'Test City',
            'districtid' => $district->districtid,
            'state_id' => $state->state_id,
            'description' => 'A test city',
        ];

        $response = $this->post('/admin/cities', $cityData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('city', $cityData);
    }

    public function test_it_can_update_a_city()
    {
        $country = Country::create([
            'country_name' => 'Test Country',
            'country_code' => 'TC',
            'description' => 'A test country',
        ]);

        $state = State::create([
            'state_title' => 'Test State',
            'country_id' => $country->country_id,
            'state_description' => 'A test state',
        ]);

        $district = District::create([
            'district_title' => 'Test District',
            'state_id' => $state->state_id,
            'district_description' => 'A test district',
        ]);

        $city = City::create([
            'name' => 'Test City',
            'districtid' => $district->districtid,
            'state_id' => $state->state_id,
            'description' => 'A test city',
        ]);

        $updatedData = [
            'name' => 'Updated Test City',
            'districtid' => $district->districtid,
            'state_id' => $state->state_id,
            'description' => 'An updated test city',
        ];

        $response = $this->put("/admin/cities/{$city->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('city', $updatedData);
    }

    public function test_it_can_delete_a_city()
    {
        $country = Country::create([
            'country_name' => 'Test Country',
            'country_code' => 'TC',
            'description' => 'A test country',
        ]);

        $state = State::create([
            'state_title' => 'Test State',
            'country_id' => $country->country_id,
            'state_description' => 'A test state',
        ]);

        $district = District::create([
            'district_title' => 'Test District',
            'state_id' => $state->state_id,
            'district_description' => 'A test district',
        ]);

        $city = City::create([
            'name' => 'Test City',
            'districtid' => $district->districtid,
            'state_id' => $state->state_id,
            'description' => 'A test city',
        ]);

        $response = $this->delete("/admin/cities/{$city->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseMissing('city', ['id' => $city->id]);
    }

    public function test_it_can_retrieve_cities_index()
    {
        $response = $this->get('/admin/cities');

        $response->assertStatus(200);
        $response->assertViewIs('admin.master-data.cities.index');
    }
}