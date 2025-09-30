<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Country;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class LocationModuleTest extends TestCase
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

    #[Test]
    public function it_can_create_a_country()
    {
        $countryData = [
            'country_name' => 'Test Country',
            'country_code' => 'TC',
            'description' => 'A test country',
        ];

        $response = $this->post('/admin/countries', $countryData);

        $response->assertStatus(200); // Successful AJAX response
        $this->assertDatabaseHas('countries', $countryData);
    }

    #[Test]
    public function it_can_create_a_state()
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

        $response->assertStatus(200); // Successful AJAX response
        $this->assertDatabaseHas('state', $stateData);
    }

    #[Test]
    public function it_can_create_a_district()
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

        $response->assertStatus(200); // Successful AJAX response
        $this->assertDatabaseHas('district', $districtData);
    }

    #[Test]
    public function it_can_create_a_city()
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

        $response->assertStatus(200); // Successful AJAX response
        $this->assertDatabaseHas('city', $cityData);
    }

    #[Test]
    public function it_can_retrieve_countries_index()
    {
        $response = $this->get('/admin/countries');

        $response->assertStatus(200);
        $response->assertViewIs('admin.master-data.countries.index');
    }

    #[Test]
    public function it_can_retrieve_states_index()
    {
        $response = $this->get('/admin/states');

        $response->assertStatus(200);
        $response->assertViewIs('admin.master-data.states.index');
    }

    #[Test]
    public function it_can_retrieve_districts_index()
    {
        $response = $this->get('/admin/districts');

        $response->assertStatus(200);
        $response->assertViewIs('admin.master-data.districts.index');
    }

    #[Test]
    public function it_can_retrieve_cities_index()
    {
        $response = $this->get('/admin/cities');

        $response->assertStatus(200);
        $response->assertViewIs('admin.master-data.cities.index');
    }
}