<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\District;
use PHPUnit\Framework\Attributes\Test;

class AddNewDropdownTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test user
        $user = User::factory()->create([
            'role' => 'admin'
        ]);
        
        $this->actingAs($user);
    }

    #[Test]
    public function it_can_add_a_new_state_via_ajax()
    {
        // Create a country first
        $country = Country::create([
            'country_name' => 'Test Country',
            'country_code' => 'TC'
        ]);
        
        $response = $this->postJson(route('admin.locations.entities.store'), [
            'entity_type' => 'state',
            'name' => 'Test State',
            'country_id' => $country->country_id,
            'description' => 'A test state'
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'entity_type' => 'state'
                 ]);
                 
        $this->assertDatabaseHas('state', [
            'state_title' => 'Test State',
            'country_id' => $country->country_id
        ]);
    }

    #[Test]
    public function it_can_add_a_new_district_via_ajax()
    {
        // Create required entities first
        $country = Country::create([
            'country_name' => 'Test Country',
            'country_code' => 'TC'
        ]);
        
        $state = State::create([
            'state_title' => 'Test State',
            'country_id' => $country->country_id
        ]);
        
        $response = $this->postJson(route('admin.locations.entities.store'), [
            'entity_type' => 'district',
            'name' => 'Test District',
            'state_id' => $state->state_id,
            'description' => 'A test district'
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'entity_type' => 'district'
                 ]);
                 
        $this->assertDatabaseHas('district', [
            'district_title' => 'Test District',
            'state_id' => $state->state_id
        ]);
    }

    #[Test]
    public function it_can_add_a_new_city_via_ajax()
    {
        // Create required entities first
        $country = Country::create([
            'country_name' => 'Test Country',
            'country_code' => 'TC'
        ]);
        
        $state = State::create([
            'state_title' => 'Test State',
            'country_id' => $country->country_id
        ]);
        
        $district = District::create([
            'district_title' => 'Test District',
            'state_id' => $state->state_id
        ]);
        
        $response = $this->postJson(route('admin.locations.entities.store'), [
            'entity_type' => 'city',
            'name' => 'Test City',
            'districtid' => $district->districtid,
            'state_id' => $state->state_id,
            'description' => 'A test city'
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'entity_type' => 'city'
                 ]);
                 
        $this->assertDatabaseHas('city', [
            'name' => 'Test City',
            'districtid' => $district->districtid,
            'state_id' => $state->state_id
        ]);
    }

    #[Test]
    public function it_validates_required_fields()
    {
        $response = $this->postJson(route('admin.locations.entities.store'), [
            'entity_type' => 'state'
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'country_id']);
    }
}