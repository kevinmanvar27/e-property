<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\State;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a sample country
        $country = Country::create([
            'country_name' => 'India',
            'country_code' => 'IND',
            'description' => 'Republic of India',
            'status' => 'active',
        ]);

        // Create sample states
        $state1 = State::create([
            'country_id' => $country->country_id,
            'state_title' => 'Maharashtra',
            'state_description' => 'State of Maharashtra',
            'status' => 'active',
        ]);

        $state2 = State::create([
            'country_id' => $country->country_id,
            'state_title' => 'Gujarat',
            'state_description' => 'State of Gujarat',
            'status' => 'active',
        ]);

        // Create sample districts
        $district1 = District::create([
            'state_id' => $state1->state_id,
            'district_title' => 'Mumbai',
            'district_description' => 'Mumbai District',
            'district_status' => 'active',
        ]);

        $district2 = District::create([
            'state_id' => $state1->state_id,
            'district_title' => 'Pune',
            'district_description' => 'Pune District',
            'district_status' => 'active',
        ]);

        $district3 = District::create([
            'state_id' => $state2->state_id,
            'district_title' => 'Ahmedabad',
            'district_description' => 'Ahmedabad District',
            'district_status' => 'active',
        ]);

        // Create sample cities/talukas
        City::create([
            'name' => 'Mumbai City',
            'districtid' => $district1->districtid,
            'state_id' => $state1->state_id,
            'description' => 'Mumbai City',
            'status' => 'active',
        ]);

        City::create([
            'name' => 'Navi Mumbai',
            'districtid' => $district1->districtid,
            'state_id' => $state1->state_id,
            'description' => 'Navi Mumbai City',
            'status' => 'active',
        ]);

        City::create([
            'name' => 'Pune City',
            'districtid' => $district2->districtid,
            'state_id' => $state1->state_id,
            'description' => 'Pune City',
            'status' => 'active',
        ]);

        City::create([
            'name' => 'Ahmedabad City',
            'districtid' => $district3->districtid,
            'state_id' => $state2->state_id,
            'description' => 'Ahmedabad City',
            'status' => 'active',
        ]);
    }
}
