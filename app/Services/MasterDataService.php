<?php

namespace App\Services;

use App\Models\Amenity;
use App\Models\LandType;

class MasterDataService
{
    /**
     * Store a new amenity
     */
    public function storeAmenity(array $data)
    {
        return Amenity::create([
            'name' => $data['name'],
        ]);
    }

    /**
     * Store a new land type
     */
    public function storeLandType(array $data)
    {
        return LandType::create([
            'name' => $data['name'],
        ]);
    }
}
