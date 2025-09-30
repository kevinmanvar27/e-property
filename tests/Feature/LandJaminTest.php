<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Property;
use App\Models\Amenity;
use App\Models\LandType;
use App\Models\Country;
use PHPUnit\Framework\Attributes\Test;

class LandJaminTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_land_jamin_record()
    {
        // Create a country first for the foreign key constraint
        $country = Country::create([
            'country_name' => 'India',
            'country_code' => 'IN'
        ]);

        $landData = [
            'owner_name' => 'John Doe',
            'first_line' => '123 Main Street',
            'second_line' => 'Apartment 4B',
            'village' => 'Test Village',
            'taluka_id' => null,
            'district_id' => 1,
            'state_id' => 1,
            'pincode' => '123456',
            'country_id' => $country->country_id, // Use country_id instead of country
            'vavetar' => 'Yes',
            'any_issue' => 'No',
            'electric_poll' => 'Yes',
            'electric_poll_count' => 2,
            'family_issue' => 'No',
            'road_distance' => 100.50,
            'additional_notes' => 'Test notes',
            'property_type' => 'land_jamin', // Add property type
        ];

        $land = Property::create($landData);

        $this->assertDatabaseHas('properties', [
            'owner_name' => 'John Doe',
            'first_line' => '123 Main Street',
            'village' => 'Test Village',
        ]);

        $this->assertInstanceOf(Property::class, $land);
    }

    #[Test]
    public function it_can_create_an_amenity()
    {
        $amenityData = [
            'name' => 'Swimming Pool',
            'description' => 'Swimming pool with lifeguard',
        ];

        $amenity = Amenity::create($amenityData);

        $this->assertDatabaseHas('amenities', [
            'name' => 'Swimming Pool',
        ]);

        $this->assertInstanceOf(Amenity::class, $amenity);
    }

    #[Test]
    public function it_can_create_a_land_type()
    {
        $landTypeData = [
            'name' => 'Agricultural Land',
            'description' => 'Land suitable for agriculture',
        ];

        $landType = LandType::create($landTypeData);

        $this->assertDatabaseHas('land_types', [
            'name' => 'Agricultural Land',
        ]);

        $this->assertInstanceOf(LandType::class, $landType);
    }
}