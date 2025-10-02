<?php

namespace App\Http\Controllers;

use App\Http\Requests\AmenityStoreRequest;
use App\Http\Requests\AmenityUpdateRequest;
use App\Http\Requests\LandTypeStoreRequest;
use App\Http\Requests\LandTypeUpdateRequest;
use App\Models\Amenity;
use App\Models\LandType;

class MasterDataController extends Controller
{
    /**
     * Display a listing of amenities
     */
    public function indexAmenities()
    {
        $amenities = Amenity::all();

        return view('admin.master-data.amenities.index', compact('amenities'));
    }

    /**
     * Store a newly created amenity in storage
     */
    public function storeAmenity(AmenityStoreRequest $request)
    {
        $amenity = Amenity::create($request->only(['name', 'description']));

        return response()->json(['success' => true, 'amenity' => $amenity]);
    }

    /**
     * Update the specified amenity in storage
     */
    public function updateAmenity(AmenityUpdateRequest $request, Amenity $amenity)
    {
        $amenity->update($request->only(['name', 'description']));

        return response()->json(['success' => true, 'amenity' => $amenity]);
    }

    /**
     * Remove the specified amenity from storage
     */
    public function destroyAmenity(Amenity $amenity)
    {
        $amenity->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Display a listing of land types
     */
    public function indexLandTypes()
    {
        $landTypes = LandType::all();

        return view('admin.master-data.land-types.index', compact('landTypes'));
    }

    /**
     * Store a newly created land type in storage
     */
    public function storeLandType(LandTypeStoreRequest $request)
    {
        $landType = LandType::create($request->only(['name', 'description']));

        return response()->json(['success' => true, 'landType' => $landType]);
    }

    /**
     * Update the specified land type in storage
     */
    public function updateLandType(LandTypeUpdateRequest $request, LandType $landType)
    {
        $landType->update($request->only(['name', 'description']));

        return response()->json(['success' => true, 'landType' => $landType]);
    }

    /**
     * Remove the specified land type from storage
     */
    public function destroyLandType(LandType $landType)
    {
        $landType->delete();

        return response()->json(['success' => true]);
    }
}
