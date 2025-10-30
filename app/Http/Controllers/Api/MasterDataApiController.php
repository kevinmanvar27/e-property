<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\LandType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Schema(
 *     schema="Amenity",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Swimming Pool"),
 *     @OA\Property(property="description", type="string", example="Swimming pool facility"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
 * )
 *
 * @OA\Schema(
 *     schema="LandType",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Agricultural"),
 *     @OA\Property(property="description", type="string", example="Agricultural land"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
 * )
 *
 * @OA\Schema(
 *     schema="AmenitiesResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Amenity")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="LandTypesResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/LandType")
 *     )
 * )
 *
 * @OA\Tag(
 *     name="Master Data",
 *     description="API Endpoints for Master Data Management"
 * )
 */

class MasterDataApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/amenities",
     *      operationId="getAmenities",
     *      tags={"Master Data"},
     *      summary="Get list of amenities",
     *      description="Returns list of all amenities",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/AmenitiesResponse")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
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
            Log::error('Error loading amenities: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading amenities. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/amenities",
     *      operationId="createAmenity",
     *      tags={"Master Data"},
     *      summary="Create new amenity",
     *      description="Creates a new amenity",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Swimming Pool"),
     *              @OA\Property(property="description", type="string", example="Swimming pool facility")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Amenity created successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/Amenity")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
     */
    public function storeAmenity(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:amenities,name',
                'description' => 'nullable|string|max:255',
            ]);

            $amenity = Amenity::create($request->only('name', 'description'));

            return response()->json([
                'success' => true,
                'message' => 'Amenity created successfully',
                'data' => $amenity,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating amenity: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the amenity. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/amenities/{id}",
     *      operationId="updateAmenity",
     *      tags={"Master Data"},
     *      summary="Update amenity",
     *      description="Updates an amenity",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Amenity id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Swimming Pool"),
     *              @OA\Property(property="description", type="string", example="Swimming pool facility")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Amenity updated successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/Amenity")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Amenity not found"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
     */
    public function updateAmenity(Request $request, Amenity $amenity)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:amenities,name,' . $amenity->id,
                'description' => 'nullable|string|max:255'
                
            ]);

            $amenity->update($request->only('name', 'description'));

            return response()->json([
                'success' => true,
                'message' => 'Amenity updated successfully',
                'data' => $amenity,
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating amenity: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the amenity. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/amenities/{id}",
     *      operationId="deleteAmenity",
     *      tags={"Master Data"},
     *      summary="Delete amenity",
     *      description="Deletes an amenity",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Amenity id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Amenity deleted successfully")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Amenity not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
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
            Log::error('Error deleting amenity: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the amenity. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/land-types",
     *      operationId="getLandTypes",
     *      tags={"Master Data"},
     *      summary="Get list of land types",
     *      description="Returns list of all land types",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/LandTypesResponse")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
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
            Log::error('Error loading land types: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading land types. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/land-types",
     *      operationId="createLandType",
     *      tags={"Master Data"},
     *      summary="Create new land type",
     *      description="Creates a new land type",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Agricultural"),
     *              @OA\Property(property="description", type="string", example="Agricultural land")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Land type created successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/LandType")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
     */
    public function storeLandType(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:land_types,name',
                'description' => 'nullable|string|max:255'
            ]);

            $landType = LandType::create($request->only('name', 'description'));

            return response()->json([
                'success' => true,
                'message' => 'Land type created successfully',
                'data' => $landType,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating land type: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the land type. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/land-types/{id}",
     *      operationId="updateLandType",
     *      tags={"Master Data"},
     *      summary="Update land type",
     *      description="Updates a land type",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Land type id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Agricultural"),
     *              @OA\Property(property="description", type="string", example="Agricultural land")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Land type updated successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/LandType")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Land type not found"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
     */
    public function updateLandType(Request $request, LandType $landType)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:land_types,name,' . $landType->id,
                'description' => 'nullable|string|max:255'
            ]);

            $landType->update($request->only('name', 'description'));

            return response()->json([
                'success' => true,
                'message' => 'Land type updated successfully',
                'data' => $landType,
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating land type: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the land type. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/land-types/{id}",
     *      operationId="deleteLandType",
     *      tags={"Master Data"},
     *      summary="Delete land type",
     *      description="Deletes a land type",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Land type id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Land type deleted successfully")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Land type not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
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
            Log::error('Error deleting land type: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the land type. Please try again.',
            ], 500);
        }
    }
}