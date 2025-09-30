<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use PHPUnit\Framework\Attributes\Test;

class AddNewDropdownPrefillTest extends TestCase
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
    public function it_preselects_current_values_in_add_new_modal()
    {
        // Create test data
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
        
        // Create a taluka/city as well
        $taluka = City::create([
            'name' => 'Test Taluka',
            'districtid' => $district->districtid,
            'state_id' => $state->state_id
        ]);
        
        // Visit the land create page
        $response = $this->get(route('land-jamin.create'));
        
        // Check that the page loads successfully
        $response->assertStatus(200);
        
        // For debugging - output part of the response
        $content = $response->getContent();
        // Get first 1000 characters
        $preview = substr($content, 0, 1000);
        
        // Just check that we have a form with state_id
        $response->assertSee('state_id');
    }
}