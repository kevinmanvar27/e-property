<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Models\Property;
use App\Services\DocumentService;
use App\Services\LocationService;
use App\Services\MasterDataService;
use App\Services\PhotoService;
use App\Services\PropertyService;
use Illuminate\Http\Request;

class BasePropertyController extends Controller
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
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $properties = Property::with(['state', 'district', 'taluka'])
                ->where('property_type', $this->propertyType)
                ->select(['id', 'owner_name', 'village', 'taluka_id', 'district_id', 'state_id', 'status', 'property_type', 'created_at'])
                ->get();

            return view('admin.' . str_replace('_', '-', $this->propertyType) . '.index', compact('properties'));
        } catch (\Exception $e) {
            \Log::error('Error loading properties: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while loading properties. Please try again.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $countries = $this->propertyService->getCountries();
            $states = $this->propertyService->getStates();
            $amenities = $this->propertyService->getAmenities();
            $landTypes = $this->propertyService->getLandTypes();

            return view('admin.' . str_replace('_', '-', $this->propertyType) . '.create', compact('countries', 'states', 'amenities', 'landTypes'));
        } catch (\Exception $e) {
            \Log::error('Error loading create property form: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while loading the form. Please try again.');
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
                    'errors' => [
                        'general' => ['The uploaded files are too large. Please reduce the file sizes and try again. Current limit is 100MB per file.'],
                    ],
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
                'any_issue',
                'issue_description',
                'electric_poll',
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

            return response()->json(['message' => 'Property created successfully', 'property' => $property]);
        } catch (\Exception $e) {
            \Log::error('Error creating property: ' . $e->getMessage());

            return response()->json(['errors' => ['general' => ['An error occurred while creating the property. Please try again.']]], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        // Ensure property is of the correct type
        if ($property->property_type !== $this->propertyType) {
            abort(404);
        }

        $property->load(['state', 'district', 'taluka', 'amenities', 'landTypes']);

        return view('admin.' . str_replace('_', '-', $this->propertyType) . '.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        // Ensure property is of the correct type
        if ($property->property_type !== $this->propertyType) {
            abort(404);
        }

        $countries = $this->propertyService->getCountries();
        $states = $this->propertyService->getStates();
        $districts = $this->propertyService->getDistrictsByState($property->state_id);
        $talukas = $this->propertyService->getTalukasByDistrict($property->district_id);
        $amenities = $this->propertyService->getAmenities();
        $landTypes = $this->propertyService->getLandTypes();

        $property->load(['amenities', 'landTypes']);

        return view('admin.' . str_replace('_', '-', $this->propertyType) . '.edit', compact('property', 'countries', 'states', 'districts', 'talukas', 'amenities', 'landTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyUpdateRequest $request, Property $property)
    {
        try {
            // Ensure property is of the correct type
            if ($property->property_type !== $this->propertyType) {
                return response()->json(['errors' => ['general' => ['Property not found.']]], 404);
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
                'any_issue',
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

            return response()->json(['message' => 'Property updated successfully', 'property' => $property]);
        } catch (\Exception $e) {
            \Log::error('Error updating property: ' . $e->getMessage());

            return response()->json(['errors' => ['general' => ['An error occurred while updating the property. Please try again.']]], 500);
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
                return response()->json(['message' => 'Property not found'], 404);
            }

            // Delete associated files using service
            $this->propertyService->deletePropertyFiles($property);

            $property->delete();

            return response()->json(['message' => 'Property deleted successfully']);
        } catch (\Exception $e) {
            \Log::error('Error deleting property: ' . $e->getMessage());

            return response()->json(['message' => 'An error occurred while deleting the property. Please try again.'], 500);
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
                return response()->json(['message' => 'Property not found'], 404);
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
                'message' => 'Status updated successfully',
                'status_text' => $statusText,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating property status: ' . $e->getMessage());

            return response()->json(['message' => 'An error occurred while updating the property status. Please try again.'], 500);
        }
    }

    /**
     * Get states by country
     */
    public function getStatesByCountry($countryId)
    {
        $states = $this->locationService->getStatesByCountry($countryId);

        return response()->json($states);
    }

    /**
     * Get districts by state
     */
    public function getDistrictsByState($stateId)
    {
        $districts = $this->locationService->getDistrictsByState($stateId);

        return response()->json($districts);
    }

    /**
     * Get talukas by district
     */
    public function getTalukasByDistrict($districtId)
    {
        $talukas = $this->locationService->getTalukasByDistrict($districtId);

        return response()->json($talukas);
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

        return response()->json(['message' => 'Amenity created successfully', 'amenity' => $amenity]);
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

        return response()->json(['message' => 'Land type created successfully', 'landType' => $landType]);
    }

    /**
     * Update photo positions
     */
    public function updatePhotoPositions(Request $request, Property $property)
    {
        try {
            // Ensure property is of the correct type
            if ($property->property_type !== $this->propertyType) {
                return response()->json(['message' => 'Property not found'], 404);
            }

            $request->validate([
                'positions' => 'required|array',
            ]);

            $this->photoService->updatePhotoPositions($property, $request->positions);

            return response()->json(['message' => 'Photo positions updated successfully']);
        } catch (\Exception $e) {
            \Log::error('Error updating photo positions: ' . $e->getMessage());

            return response()->json(['message' => 'An error occurred while updating photo positions. Please try again.'], 500);
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
                return response()->json(['message' => 'Property not found'], 404);
            }

            $this->photoService->deletePhoto($property, $photoIndex);

            return response()->json(['message' => 'Photo deleted successfully']);
        } catch (\Exception $e) {
            \Log::error('Error deleting photo: ' . $e->getMessage());

            return response()->json(['message' => 'An error occurred while deleting the photo. Please try again.'], 500);
        }
    }
}
