<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amenity;
use App\Models\LandType;
use Illuminate\Support\Facades\Validator;

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
    public function storeAmenity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:amenities',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $amenity = Amenity::create($request->only(['name', 'description']));

        return response()->json(['success' => true, 'amenity' => $amenity]);
    }

    /**
     * Update the specified amenity in storage
     */
    public function updateAmenity(Request $request, Amenity $amenity)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:amenities,name,' . $amenity->id,
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

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
    public function storeLandType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:land_types',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $landType = LandType::create($request->only(['name', 'description']));

        return response()->json(['success' => true, 'landType' => $landType]);
    }

    /**
     * Update the specified land type in storage
     */
    public function updateLandType(Request $request, LandType $landType)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:land_types,name,' . $landType->id,
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

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