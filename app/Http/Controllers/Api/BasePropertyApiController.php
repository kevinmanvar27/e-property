<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Models\Property;
use App\Services\DocumentService;
use App\Services\LocationService;
use App\Services\MasterDataService;
use App\Services\PhotoService;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Schema(
 *     schema="Property",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="owner_name", type="string", example="John Doe"),
 *     @OA\Property(property="contact_number", type="string", example="1234567890"),
 *     @OA\Property(property="size", type="string", example="1000 sq ft"),
 *     @OA\Property(property="apartment_name", type="string", example="Sunshine Apartments"),
 *     @OA\Property(property="bhk", type="integer", example=2),
 *     @OA\Property(property="is_apartment", type="boolean", example=true),
 *     @OA\Property(property="apartment_floor", type="integer", example=3),
 *     @OA\Property(property="is_tenament", type="boolean", example=false),
 *     @OA\Property(property="tenament_floors", type="integer", example=1),
 *     @OA\Property(property="first_line", type="string", example="123 Main Street"),
 *     @OA\Property(property="second_line", type="string", example="Apartment 4B"),
 *     @OA\Property(property="village", type="string", example="Green Valley"),
 *     @OA\Property(property="taluka_id", type="integer", example=1),
 *     @OA\Property(property="district_id", type="integer", example=1),
 *     @OA\Property(property="state_id", type="integer", example=1),
 *     @OA\Property(property="pincode", type="string", example="123456"),
 *     @OA\Property(property="country_id", type="integer", example=1),
 *     @OA\Property(property="property_type", type="string", example="land_jamin"),
 *     @OA\Property(property="status", type="string", example="active"),
 *     @OA\Property(property="vavetar", type="string", example="Yes"),
 *     @OA\Property(property="any_issue", type="string", example="No"),
 *     @OA\Property(property="issue_description", type="string", example=""),
 *     @OA\Property(property="electric_poll", type="string", example="Yes"),
 *     @OA\Property(property="electric_poll_count", type="integer", example=2),
 *     @OA\Property(property="family_issue", type="string", example="No"),
 *     @OA\Property(property="family_issue_description", type="string", example=""),
 *     @OA\Property(property="road_distance", type="string", example="500 meters"),
 *     @OA\Property(property="additional_notes", type="string", example="Near school"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
 * )
 *
 * @OA\Schema(
 *     schema="PropertyResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="data", ref="#/components/schemas/Property")
 * )
 *
 * @OA\Schema(
 *     schema="PropertiesResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Property")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="An error occurred")
 * )
 *
 * @OA\Tag(
 *     name="Global Search",
 *     description="API Endpoints for Global Property Search"
 * )
 */

class BasePropertyApiController extends Controller
{
    protected $propertyType = 'land_jamin';
    protected $propertyService;
    protected $photoService;
    protected $documentService;
    protected $locationService;
    protected $masterDataService;

    public function __construct(
        PropertyService $propertyService,
        PhotoService $photoService,
        DocumentService $documentService,
        LocationService $locationService,
        MasterDataService $masterDataService
    ) {
        $this->propertyService = $propertyService;
        $this->photoService = $photoService;
        $this->documentService = $documentService;
        $this->locationService = $locationService;
        $this->masterDataService = $masterDataService;
    }

    /**
     * @OA\Get(
     *      path="/api/properties/search",
     *      operationId="searchAllProperties",
     *      tags={"Global Search"},
     *      summary="Search across all property types",
     *      description="Returns paginated list of properties from all types that match the search criteria",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="search",
     *          in="query",
     *          description="Search query for property fields",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="country_ids",
     *          in="query",
     *          description="Filter by country IDs (comma separated)",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="state_ids",
     *          in="query",
     *          description="Filter by state IDs (comma separated)",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="district_ids",
     *          in="query",
     *          description="Filter by district IDs (comma separated)",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="city_ids",
     *          in="query",
     *          description="Filter by city IDs (comma separated)",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="per_page",
     *          in="query",
     *          description="Number of items per page",
     *          @OA\Schema(type="integer", default=10)
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Page number",
     *          @OA\Schema(type="integer", default=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PropertiesResponse")
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
    public function searchAll(Request $request)
    {
        try {
            // Get filter query params
            $countryIds = $request->input('country_ids') ? explode(',', $request->input('country_ids')) : [];
            $stateIds   = $request->input('state_ids') ? explode(',', $request->input('state_ids')) : [];
            $districtIds = $request->input('district_ids') ? explode(',', $request->input('district_ids')) : [];
            $cityIds = $request->input('city_ids') ? explode(',', $request->input('city_ids')) : [];
            $searchQuery = $request->input('search', '');
            
            // Get pagination params
            $perPage = $request->input('per_page', 10); // Default to 10 items per page
            $page = $request->input('page', 1); // Default to first page

            // Build the base query - no property type filter
            $query = Property::with(['state', 'district', 'taluka'])
                ->select(['id', 'owner_name', 'village', 'taluka_id', 'district_id', 'state_id', 'status', 'property_type', 'created_at', 'photos']);

            // Apply search filter
            if (!empty($searchQuery)) {
                $query->where(function($q) use ($searchQuery) {
                    // Search in all text-based property fields
                    $q->where('owner_name', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('contact_number', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('size', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('apartment_name', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('first_line', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('second_line', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('village', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('pincode', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('vavetar_name', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('issue_description', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('family_issue_description', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('road_distance', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('additional_notes', 'LIKE', "%{$searchQuery}%")
                      // Search in location relationships
                      ->orWhereHas('state', function($stateQuery) use ($searchQuery) {
                          $stateQuery->where('state_title', 'LIKE', "%{$searchQuery}%");
                      })
                      ->orWhereHas('district', function($districtQuery) use ($searchQuery) {
                          $districtQuery->where('district_title', 'LIKE', "%{$searchQuery}%");
                      })
                      ->orWhereHas('taluka', function($talukaQuery) use ($searchQuery) {
                          $talukaQuery->where('name', 'LIKE', "%{$searchQuery}%");
                      });
                });
            }

            // Apply filters only if arrays are not empty
            if (!empty($countryIds)) {
                $query->whereIn('country_id', $countryIds);
            }

            if (!empty($stateIds)) {
                $query->whereIn('state_id', $stateIds);
            }

            if (!empty($districtIds)) {
                $query->whereIn('district_id', $districtIds);
            }

            if (!empty($cityIds)) {
                $query->whereIn('taluka_id', $cityIds);
            }

            // Apply pagination
            $properties = $query->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'success' => true,
                'data' => $properties,
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading properties: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading properties. Please try again.',
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Get filter query params
            $countryIds = $request->input('country_ids') ? explode(',', $request->input('country_ids')) : [];
            $stateIds   = $request->input('state_ids') ? explode(',', $request->input('state_ids')) : [];
            $districtIds = $request->input('district_ids') ? explode(',', $request->input('district_ids')) : [];
            $cityIds = $request->input('city_ids') ? explode(',', $request->input('city_ids')) : [];
            $searchQuery = $request->input('search', '');
            
            // Get pagination params
            $perPage = $request->input('per_page', 10); // Default to 10 items per page
            $page = $request->input('page', 1); // Default to first page

            // Build the base query
            $query = Property::with(['state', 'district', 'taluka'])
                ->where('property_type', $this->propertyType)
                ->select(['id', 'owner_name', 'village', 'taluka_id', 'district_id', 'state_id', 'status', 'property_type', 'created_at', 'photos']);

            // Apply search filter
            if (!empty($searchQuery)) {
                $query->where(function($q) use ($searchQuery) {
                    // Search in all text-based property fields
                    $q->where('owner_name', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('contact_number', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('size', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('apartment_name', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('first_line', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('second_line', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('village', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('pincode', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('vavetar_name', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('issue_description', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('family_issue_description', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('road_distance', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('additional_notes', 'LIKE', "%{$searchQuery}%")
                      // Search in location relationships
                      ->orWhereHas('state', function($stateQuery) use ($searchQuery) {
                          $stateQuery->where('state_title', 'LIKE', "%{$searchQuery}%");
                      })
                      ->orWhereHas('district', function($districtQuery) use ($searchQuery) {
                          $districtQuery->where('district_title', 'LIKE', "%{$searchQuery}%");
                      })
                      ->orWhereHas('taluka', function($talukaQuery) use ($searchQuery) {
                          $talukaQuery->where('name', 'LIKE', "%{$searchQuery}%");
                      });
                });
            }

            // Apply filters only if arrays are not empty
            if (!empty($countryIds)) {
                $query->whereIn('country_id', $countryIds);
            }

            if (!empty($stateIds)) {
                $query->whereIn('state_id', $stateIds);
            }

            if (!empty($districtIds)) {
                $query->whereIn('district_id', $districtIds);
            }

            if (!empty($cityIds)) {
                $query->whereIn('taluka_id', $cityIds);
            }

            // Apply pagination
            $properties = $query->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'success' => true,
                'data' => $properties,
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading properties: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading properties. Please try again.',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyStoreRequest $request)
    {
        try {
            // Check if the request exceeds PHP's post_max_size
            $postMaxSize = ini_get('post_max_size');
            $unit = strtolower(substr($postMaxSize, -1));
            $value = (int) $postMaxSize;

            switch ($unit) {
                case 'g':
                    $value *= 1024; // Fall through
                    // no break
                case 'm':
                    $value *= 1024; // Fall through
                    // no break
                case 'k':
                    $value *= 1024;
            }

            if ($request->server('CONTENT_LENGTH') > $value) {
                return response()->json([
                    'success' => false,
                    'message' => 'The uploaded files are too large. Please reduce the file sizes and try again. Current limit is 100MB per file.',
                ], 413);
            }

            $data = $request->only([
                'owner_name',
                'contact_number',
                'size',
                'apartment_name',
                'bhk',
                'is_apartment',
                'apartment_floor',
                'is_tenament',
                'tenament_floors',
                'first_line',
                'second_line',
                'village',
                'taluka_id',
                'district_id',
                'state_id',
                'pincode',
                'country_id',
                'property_type',
                'status',
                'vavetar',
                'vavetar_name',
                'any_issue',
                'issue_description',
                'electric_poll',
                'amenities',
                'land_types',
                'electric_poll_count',
                'family_issue',
                'family_issue_description',
                'road_distance',
                'additional_notes',
            ]);

            // Handle document uploads using DocumentService
            $documentData = $this->documentService->handlePropertyDocumentUploads($request, new Property(), $this->propertyType);
            $data = array_merge($data, $documentData);

            // Handle photo uploads
            $photoPaths = [];
            if ($request->hasFile('photos')) {
                $photoPaths = $this->propertyService->handlePhotoUploads($request->file('photos'));
            }

            $data['property_type'] = $this->propertyType;
            $data['photos'] = json_encode($photoPaths);

            $property = Property::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Property created successfully',
                'data' => $property,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating property: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the property. Please try again.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        // Ensure property is of the correct type
        if ($property->property_type !== $this->propertyType) {
            return response()->json([
                'success' => false,
                'message' => 'Property not found',
            ], 404);
        }

        $property->load(['state', 'district', 'taluka', 'amenities', 'landTypes']);

        return response()->json([
            'success' => true,
            'data' => $property,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyUpdateRequest $request, Property $property)
    {
        try {
            // Ensure property is of the correct type
            if ($property->property_type !== $this->propertyType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property not found',
                ], 404);
            }

            $data = $request->only([
                'owner_name',
                'contact_number',
                'size',
                'apartment_name',
                'bhk',
                'is_apartment',
                'apartment_floor',
                'is_tenament',
                'tenament_floors',
                'first_line',
                'second_line',
                'village',
                'taluka_id',
                'district_id',
                'state_id',
                'pincode',
                'country_id',
                'status',
                'vavetar',
                'vavetar_name',
                'any_issue',
                'amenities',
                'land_types',
                'issue_description',
                'electric_poll',
                'electric_poll_count',
                'family_issue',
                'family_issue_description',
                'road_distance',
                'additional_notes',
            ]);

            // Handle document uploads using DocumentService
            $documentData = $this->documentService->handlePropertyDocumentUploads($request, $property, $this->propertyType);
            $data = array_merge($data, $documentData);

            // Handle photo uploads
            $existingPhotos = $property->photos ? json_decode($property->photos, true) : [];
            $photoPaths = $existingPhotos;

            if ($request->hasFile('photos')) {
                $newPhotos = $this->propertyService->handlePhotoUploads($request->file('photos'));
                $photoPaths = array_merge($photoPaths, $newPhotos);
            }

            $data['photos'] = json_encode($photoPaths);

            $property->update($data);

            // Sync amenities and land types
            if ($request->has('amenities')) {
                $property->amenities()->sync($request->amenities);
            }

            if ($request->has('land_types')) {
                $property->landTypes()->sync($request->land_types);
            }

            return response()->json([
                'success' => true,
                'message' => 'Property updated successfully',
                'data' => $property,
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating property: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the property. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        try {
            // Ensure property is of the correct type
            if ($property->property_type !== $this->propertyType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property not found',
                ], 404);
            }

            // Delete associated files using service
            $this->propertyService->deletePropertyFiles($property);

            $property->delete();

            return response()->json([
                'success' => true,
                'message' => 'Property deleted successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting property: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the property. Please try again.',
            ], 500);
        }
    }

    /**
     * Update property status
     */
    public function updateStatus(Request $request, Property $property)
    {
        try {
            // Ensure property is of the correct type
            if ($property->property_type !== $this->propertyType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property not found',
                ], 404);
            }

            $request->validate([
                'status' => 'required|string|in:active,inactive,urgent,under_offer,reserved,sold,cancelled,coming_soon,price_reduced',
            ]);

            $property->status = $request->status;
            $property->save();

            // Return appropriate status text with styling
            $statusText = '';
            switch ($property->status) {
                case 'active':
                    $statusText = '<span class="text-success fw-bold">Active</span>';

                    break;
                case 'inactive':
                    $statusText = '<span class="text-secondary fw-bold">Inactive</span>';

                    break;
                case 'urgent':
                    $statusText = '<span class="text-danger fw-bold">Urgent</span>';

                    break;
                case 'under_offer':
                    $statusText = '<span class="text-warning fw-bold">Under Offer</span>';

                    break;
                case 'reserved':
                    $statusText = '<span class="text-info fw-bold">Reserved</span>';

                    break;
                case 'sold':
                    $statusText = '<span class="text-muted fw-bold">Sold</span>';

                    break;
                case 'cancelled':
                    $statusText = '<span class="text-dark fw-bold">Cancelled</span>';

                    break;
                case 'coming_soon':
                    $statusText = '<span class="text-primary fw-bold">Coming Soon</span>';

                    break;
                case 'price_reduced':
                    $statusText = '<span class="text-orange fw-bold">Price Reduced</span>';

                    break;
            }

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'data' => [
                    'status_text' => $statusText,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating property status: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the property status. Please try again.',
            ], 500);
        }
    }

    /**
     * Get states by country
     */
    public function getStatesByCountry($countryId)
    {
        $states = $this->locationService->getStatesByCountry($countryId);

        return response()->json([
            'success' => true,
            'data' => $states,
        ]);
    }

    /**
     * Get districts by state
     */
    public function getDistrictsByState($stateId)
    {
        $districts = $this->locationService->getDistrictsByState($stateId);

        return response()->json([
            'success' => true,
            'data' => $districts,
        ]);
    }

    /**
     * Get talukas by district
     */
    public function getTalukasByDistrict($districtId)
    {
        $talukas = $this->locationService->getTalukasByDistrict($districtId);

        return response()->json([
            'success' => true,
            'data' => $talukas,
        ]);
    }

    /**
     * Store amenity
     */
    public function storeAmenity(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:amenities,name',
        ]);

        $amenity = $this->masterDataService->storeAmenity($request->only('name'));

        return response()->json([
            'success' => true,
            'message' => 'Amenity created successfully',
            'data' => $amenity,
        ]);
    }

    /**
     * Store land type
     */
    public function storeLandType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:land_types,name',
        ]);

        $landType = $this->masterDataService->storeLandType($request->only('name'));

        return response()->json([
            'success' => true,
            'message' => 'Land type created successfully',
            'data' => $landType,
        ]);
    }

    /**
     * Update photo positions
     */
    public function updatePhotoPositions(Request $request, Property $property)
    {
        try {
            // Ensure property is of the correct type
            if ($property->property_type !== $this->propertyType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property not found',
                ], 404);
            }

            $request->validate([
                'positions' => 'required|array',
            ]);

            $this->photoService->updatePhotoPositions($property, $request->positions);

            return response()->json([
                'success' => true,
                'message' => 'Photo positions updated successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating photo positions: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating photo positions. Please try again.',
            ], 500);
        }
    }

    /**
     * Delete photo
     */
    public function deletePhoto(Request $request, Property $property, $photoIndex)
    {
        try {
            // Ensure property is of the correct type
            if ($property->property_type !== $this->propertyType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property not found',
                ], 404);
            }

            $this->photoService->deletePhoto($property, $photoIndex);

            return response()->json([
                'success' => true,
                'message' => 'Photo deleted successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting photo: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the photo. Please try again.',
            ], 500);
        }
    }
}