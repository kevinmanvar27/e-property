<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\LandType;
use Illuminate\Http\Request;

class MasterDataApiController extends Controller
{
    /**
     * Get all amenities
     */
    public function indexAmenities()
    {
        try {
            $amenities = Amenity::all();

            return response()->json([
                'success' => true,
                'data' => $amenities,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading amenities: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading amenities. Please try again.',
            ], 500);
        }
    }

    /**
     * Create a new amenity
     */
    public function storeAmenity(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:amenities,name',
            ]);

            $amenity = Amenity::create($request->only('name'));

            return response()->json([
                'success' => true,
                'message' => 'Amenity created successfully',
                'data' => $amenity,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating amenity: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the amenity. Please try again.',
            ], 500);
        }
    }

    /**
     * Update an amenity
     */
    public function updateAmenity(Request $request, Amenity $amenity)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:amenities,name,' . $amenity->id,
            ]);

            $amenity->update($request->only('name'));

            return response()->json([
                'success' => true,
                'message' => 'Amenity updated successfully',
                'data' => $amenity,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating amenity: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the amenity. Please try again.',
            ], 500);
        }
    }

    /**
     * Delete an amenity
     */
    public function destroyAmenity(Amenity $amenity)
    {
        try {
            $amenity->delete();

            return response()->json([
                'success' => true,
                'message' => 'Amenity deleted successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting amenity: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the amenity. Please try again.',
            ], 500);
        }
    }

    /**
     * Get all land types
     */
    public function indexLandTypes()
    {
        try {
            $landTypes = LandType::all();

            return response()->json([
                'success' => true,
                'data' => $landTypes,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading land types: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading land types. Please try again.',
            ], 500);
        }
    }

    /**
     * Create a new land type
     */
    public function storeLandType(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:land_types,name',
            ]);

            $landType = LandType::create($request->only('name'));

            return response()->json([
                'success' => true,
                'message' => 'Land type created successfully',
                'data' => $landType,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating land type: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the land type. Please try again.',
            ], 500);
        }
    }

    /**
     * Update a land type
     */
    public function updateLandType(Request $request, LandType $landType)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:land_types,name,' . $landType->id,
            ]);

            $landType->update($request->only('name'));

            return response()->json([
                'success' => true,
                'message' => 'Land type updated successfully',
                'data' => $landType,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating land type: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the land type. Please try again.',
            ], 500);
        }
    }

    /**
     * Delete a land type
     */
    public function destroyLandType(LandType $landType)
    {
        try {
            $landType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Land type deleted successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting land type: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the land type. Please try again.',
            ], 500);
        }
    }
}
