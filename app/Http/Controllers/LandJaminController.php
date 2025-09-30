<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandJamin;
use App\Models\Amenity;
use App\Models\LandType;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class LandJaminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lands = LandJamin::with(['state', 'district', 'taluka'])->get();
        return view('admin.land-jamin.index', compact('lands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        $states = State::all();
        $amenities = Amenity::all();
        $landTypes = LandType::all();
        return view('admin.land-jamin.create', compact('countries', 'states', 'amenities', 'landTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Check if the request exceeds PHP's post_max_size
            if ($request->server('CONTENT_LENGTH') > $this->getPostMaxSize()) {
                return response()->json([
                    'errors' => [
                        'general' => ['The uploaded files are too large. Please reduce the file sizes and try again. Current limit is 100MB per file.']
                    ]
                ], 413);
            }

            $validator = Validator::make($request->all(), [
                'owner_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
                'contact_number' => 'nullable|string|max:15',
                'first_line' => 'required|string|max:255',
                'second_line' => 'nullable|string|max:255',
                'village' => 'required|string|max:255',
                'taluka_id' => 'nullable|exists:city,id',
                'district_id' => 'required|exists:district,districtid',
                'state_id' => 'required|exists:state,state_id',
                'pincode' => 'required|string|max:10',
                'country_id' => 'required|exists:countries,country_id',
                'vavetar' => 'nullable|in:Yes,No',
                'any_issue' => 'nullable|in:Yes,No',
                'issue_description' => 'nullable|string|max:500|required_if:any_issue,Yes',
                'electric_poll' => 'nullable|in:Yes,No',
                'electric_poll_count' => 'nullable|integer|min:1|required_if:electric_poll,Yes',
                'family_issue' => 'nullable|in:Yes,No',
                'family_issue_description' => 'nullable|string|max:500|required_if:family_issue,Yes',
                'road_distance' => 'nullable|numeric|min:0|max:999999.99',
                'additional_notes' => 'nullable|string',
                'document_7_12' => 'nullable|file|mimes:pdf,jpg,png|max:102400', // 100MB
                'document_8a' => 'nullable|file|mimes:pdf,jpg,png|max:102400', // 100MB
                'amenities' => 'nullable|array',
                'amenities.*' => 'exists:amenities,id',
                'land_types' => 'nullable|array',
                'land_types.*' => 'exists:land_types,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $data = $request->only([
                'owner_name',
                'contact_number',
                'first_line',
                'second_line',
                'village',
                'taluka_id',
                'district_id',
                'state_id',
                'pincode',
                'country_id',
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

            // Handle document uploads
            if ($request->hasFile('document_7_12')) {
                $file = $request->file('document_7_12');
                // Check if file upload failed due to size limits
                if (!$file->isValid()) {
                    return response()->json([
                        'errors' => [
                            'document_7_12' => ['The 7/12 document is too large or upload failed. Please ensure the file is under 100MB and try again.']
                        ]
                    ], 422);
                }
                // Check file size
                if ($file->getSize() > 102400 * 1024) { // 100MB in bytes (102400 KB * 1024 bytes/KB)
                    return response()->json([
                        'errors' => [
                            'document_7_12' => ['The 7/12 document is too large. Please ensure the file is under 100MB.']
                        ]
                    ], 422);
                }
                $filename = 'document_7_12_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/documents'), $filename);
                $data['document_7_12'] = $filename;
            }

            if ($request->hasFile('document_8a')) {
                $file = $request->file('document_8a');
                // Check if file upload failed due to size limits
                if (!$file->isValid()) {
                    return response()->json([
                        'errors' => [
                            'document_8a' => ['The 8A document is too large or upload failed. Please ensure the file is under 100MB and try again.']
                        ]
                    ], 422);
                }
                // Check file size
                if ($file->getSize() > 102400 * 1024) { // 100MB in bytes (102400 KB * 1024 bytes/KB)
                    return response()->json([
                        'errors' => [
                            'document_8a' => ['The 8A document is too large. Please ensure the file is under 100MB.']
                        ]
                    ], 422);
                }
                $filename = 'document_8a_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/documents'), $filename);
                $data['document_8a'] = $filename;
            }

            $land = LandJamin::create($data);

            // Attach amenities
            if ($request->has('amenities')) {
                $land->amenities()->attach($request->amenities);
            }

            // Attach land types
            if ($request->has('land_types')) {
                $land->landTypes()->attach($request->land_types);
            }

            // Handle photo uploads
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    // Check if file upload failed due to size limits
                    if (!$photo->isValid()) {
                        return response()->json([
                            'errors' => [
                                'photos' => ['One or more photos are too large or upload failed. Please ensure each photo is under 100MB and try again.']
                            ]
                        ], 422);
                    }
                    // Check file size
                    if ($photo->getSize() > 102400 * 1024) { // 100MB in bytes (102400 KB * 1024 bytes/KB)
                        return response()->json([
                            'errors' => [
                                'photos' => ['One or more photos are too large. Please ensure each photo is under 100MB.']
                            ]
                        ], 422);
                    }
                    $filename = 'photo_' . time() . '_' . $index . '.' . $photo->getClientOriginalExtension();
                    $photo->move(public_path('assets/photos'), $filename);
                    
                    $land->photos()->create([
                        'photo_path' => $filename,
                        'position' => $index,
                    ]);
                }
            }

            // Return success without message
            return response()->json(['success' => true, 'land' => $land]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('LandJamin store error: ' . $e->getMessage());
            
            // Return a user-friendly error message
            return response()->json([
                'errors' => [
                    'general' => ['An error occurred while saving the land record. Please check that your files are under 100MB and try again.']
                ]
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LandJamin $landJamin)
    {
        $land = $landJamin->load(['state', 'district', 'taluka', 'amenities', 'landTypes', 'photos', 'country']);
        return view('admin.land-jamin.show', compact('land'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LandJamin $landJamin)
    {
        $land = $landJamin->load(['state', 'district', 'taluka', 'amenities', 'landTypes']);
        $countries = Country::all();
        $states = State::all();
        $districts = District::where('state_id', $land->state_id)->get();
        $talukas = City::where('districtid', $land->district_id)->get();
        $amenities = Amenity::all();
        $landTypes = LandType::all();
        
        // Get selected amenities and land types
        $selectedAmenities = $land->amenities->pluck('id')->toArray();
        $selectedLandTypes = $land->landTypes->pluck('id')->toArray();
        
        return view('admin.land-jamin.edit', compact('land', 'countries', 'states', 'districts', 'talukas', 'amenities', 'landTypes', 'selectedAmenities', 'selectedLandTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LandJamin $landJamin)
    {
        try {
            // Check if the request exceeds PHP's post_max_size
            if ($request->server('CONTENT_LENGTH') > $this->getPostMaxSize()) {
                return response()->json([
                    'errors' => [
                        'general' => ['The uploaded files are too large. Please reduce the file sizes and try again. Current limit is 100MB per file.']
                    ]
                ], 413);
            }

            $validator = Validator::make($request->all(), [
                'owner_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
                'contact_number' => 'nullable|string|max:15',
                'first_line' => 'required|string|max:255',
                'second_line' => 'nullable|string|max:255',
                'village' => 'required|string|max:255',
                'taluka_id' => 'nullable|exists:city,id',
                'district_id' => 'required|exists:district,districtid',
                'state_id' => 'required|exists:state,state_id',
                'pincode' => 'required|string|max:10',
                'country_id' => 'required|exists:countries,country_id',
                'vavetar' => 'nullable|in:Yes,No',
                'any_issue' => 'nullable|in:Yes,No',
                'issue_description' => 'nullable|string|max:500|required_if:any_issue,Yes',
                'electric_poll' => 'nullable|in:Yes,No',
                'electric_poll_count' => 'nullable|integer|min:1|required_if:electric_poll,Yes',
                'family_issue' => 'nullable|in:Yes,No',
                'family_issue_description' => 'nullable|string|max:500|required_if:family_issue,Yes',
                'road_distance' => 'nullable|numeric|min:0|max:999999.99',
                'additional_notes' => 'nullable|string',
                'document_7_12' => 'nullable|file|mimes:pdf,jpg,png|max:102400', // 100MB
                'document_8a' => 'nullable|file|mimes:pdf,jpg,png|max:102400', // 100MB
                'amenities' => 'nullable|array',
                'amenities.*' => 'exists:amenities,id',
                'land_types' => 'nullable|array',
                'land_types.*' => 'exists:land_types,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $data = $request->only([
                'owner_name',
                'first_line',
                'second_line',
                'village',
                'taluka_id',
                'district_id',
                'state_id',
                'pincode',
                'country_id',
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

            // Handle document uploads
            if ($request->hasFile('document_7_12')) {
                $file = $request->file('document_7_12');
                // Check if file upload failed due to size limits
                if (!$file->isValid()) {
                    return response()->json([
                        'errors' => [
                            'document_7_12' => ['The 7/12 document is too large or upload failed. Please ensure the file is under 100MB and try again.']
                        ]
                    ], 422);
                }
                // Check file size
                if ($file->getSize() > 102400 * 1024) { // 100MB in bytes (102400 KB * 1024 bytes/KB)
                    return response()->json([
                        'errors' => [
                            'document_7_12' => ['The 7/12 document is too large. Please ensure the file is under 100MB.']
                        ]
                    ], 422);
                }
                
                // Delete old document if exists
                if ($landJamin->document_7_12 && file_exists(public_path('assets/documents/' . $landJamin->document_7_12))) {
                    unlink(public_path('assets/documents/' . $landJamin->document_7_12));
                }
                
                $filename = 'document_7_12_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/documents'), $filename);
                $data['document_7_12'] = $filename;
            }

            if ($request->hasFile('document_8a')) {
                $file = $request->file('document_8a');
                // Check if file upload failed due to size limits
                if (!$file->isValid()) {
                    return response()->json([
                        'errors' => [
                            'document_8a' => ['The 8A document is too large or upload failed. Please ensure the file is under 100MB and try again.']
                        ]
                    ], 422);
                }
                // Check file size
                if ($file->getSize() > 102400 * 1024) { // 100MB in bytes (102400 KB * 1024 bytes/KB)
                    return response()->json([
                        'errors' => [
                            'document_8a' => ['The 8A document is too large. Please ensure the file is under 100MB.']
                        ]
                    ], 422);
                }
                
                // Delete old document if exists
                if ($landJamin->document_8a && file_exists(public_path('assets/documents/' . $landJamin->document_8a))) {
                    unlink(public_path('assets/documents/' . $landJamin->document_8a));
                }
                
                $filename = 'document_8a_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/documents'), $filename);
                $data['document_8a'] = $filename;
            }

            $landJamin->update($data);

            // Sync amenities
            if ($request->has('amenities')) {
                $landJamin->amenities()->sync($request->amenities);
            }

            // Sync land types
            if ($request->has('land_types')) {
                $landJamin->landTypes()->sync($request->land_types);
            }

            // Handle photo uploads
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    // Check if file upload failed due to size limits
                    if (!$photo->isValid()) {
                        return response()->json([
                            'errors' => [
                                'photos' => ['One or more photos are too large or upload failed. Please ensure each photo is under 100MB and try again.']
                            ]
                        ], 422);
                    }
                    // Check file size
                    if ($photo->getSize() > 102400 * 1024) { // 100MB in bytes (102400 KB * 1024 bytes/KB)
                        return response()->json([
                            'errors' => [
                                'photos' => ['One or more photos are too large. Please ensure each photo is under 100MB.']
                            ]
                        ], 422);
                    }
                    $filename = 'photo_' . time() . '_' . $index . '.' . $photo->getClientOriginalExtension();
                    $photo->move(public_path('assets/photos'), $filename);
                    
                    $landJamin->photos()->create([
                        'photo_path' => $filename,
                        'position' => $index,
                    ]);
                }
            }

            // Return success without message
            return response()->json(['success' => true, 'land' => $landJamin]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('LandJamin update error: ' . $e->getMessage());
            
            // Return a user-friendly error message
            return response()->json([
                'errors' => [
                    'general' => ['An error occurred while updating the land record. Please check that your files are under 100MB and try again.']
                ]
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LandJamin $landJamin)
    {
        // Delete documents if they exist
        if ($landJamin->document_7_12 && file_exists(public_path('assets/documents/' . $landJamin->document_7_12))) {
            unlink(public_path('assets/documents/' . $landJamin->document_7_12));
        }
        
        if ($landJamin->document_8a && file_exists(public_path('assets/documents/' . $landJamin->document_8a))) {
            unlink(public_path('assets/documents/' . $landJamin->document_8a));
        }
        
        // Delete photos
        foreach ($landJamin->photos as $photo) {
            if (file_exists(public_path('assets/photos/' . $photo->photo_path))) {
                unlink(public_path('assets/photos/' . $photo->photo_path));
            }
        }
        
        // Delete the land record
        $landJamin->delete();

        // Return success without message
        return response()->json(['success' => true]);
    }

    /**
     * Get districts by state ID
     */
    public function getDistrictsByState($stateId)
    {
        $districts = District::where('state_id', $stateId)->get();
        return response()->json($districts);
    }

    /**
     * Get talukas by district ID
     */
    public function getTalukasByDistrict($districtId)
    {
        $talukas = City::where('districtid', $districtId)->get();
        return response()->json($talukas);
    }

    /**
     * Get states by country ID
     */
    public function getStatesByCountry($countryId)
    {
        $states = State::where('country_id', $countryId)->get();
        return response()->json($states);
    }

    /**
     * Store a new amenity
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

        // Return success without message
        return response()->json(['success' => true, 'amenity' => $amenity]);
    }

    /**
     * Store a new land type
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

        // Return success without message
        return response()->json(['success' => true, 'landType' => $landType]);
    }

    /**
     * Update photo positions
     */
    public function updatePhotoPositions(Request $request, LandJamin $landJamin)
    {
        $positions = $request->input('positions', []);
        
        foreach ($positions as $photoId => $position) {
            $landJamin->photos()->where('id', $photoId)->update(['position' => $position]);
        }
        
        // Return success without message
        return response()->json(['success' => true]);
    }

    /**
     * Delete a photo
     */
    public function deletePhoto($photoId)
    {
        $photo = \App\Models\LandPhoto::findOrFail($photoId);
        
        // Delete the file
        if (file_exists(public_path('assets/photos/' . $photo->photo_path))) {
            unlink(public_path('assets/photos/' . $photo->photo_path));
        }
        
        // Delete the record
        $photo->delete();
        
        // Return success without message
        return response()->json(['success' => true]);
    }

    /**
     * Get post_max_size in bytes
     */
    private function getPostMaxSize()
    {
        $postMaxSize = ini_get('post_max_size');
        $unit = strtolower(substr($postMaxSize, -1));
        $value = (int) $postMaxSize;
        
        switch ($unit) {
            case 'g':
                return $value * 1024 * 1024 * 1024;
            case 'm':
                return $value * 1024 * 1024;
            case 'k':
                return $value * 1024;
            default:
                return $value;
        }
    }
    
    /**
     * Update the status of the specified land record.
     */
    public function updateStatus(Request $request, LandJamin $landJamin)
    {
        try {
            // Validate the status value
            $validStatuses = ['active', 'inactive', 'urgent', 'under_offer', 'reserved', 'sold', 'cancelled', 'coming_soon', 'price_reduced'];
            $request->validate([
                'status' => 'required|in:' . implode(',', $validStatuses)
            ]);
            
            // Update status
            $landJamin->status = $request->status;
            $landJamin->save();
            
            // Return appropriate status text with styling
            $statusText = $this->getStatusBadge($landJamin->status);
            
            return response()->json([
                'success' => true,
                'status' => $landJamin->status,
                'status_text' => $statusText
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating land status: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while updating the land status. Please try again.'], 500);
        }
    }
    
    /**
     * Get status badge HTML based on status value
     */
    private function getStatusBadge($status)
    {
        $statusBadges = [
            'active' => '<span class="badge bg-success">Active</span>',
            'inactive' => '<span class="badge bg-danger">Inactive</span>',
            'urgent' => '<span class="badge bg-danger">Urgent</span>',
            'under_offer' => '<span class="badge bg-warning">Under Offer</span>',
            'reserved' => '<span class="badge bg-info">Reserved</span>',
            'sold' => '<span class="badge bg-secondary">Sold</span>',
            'cancelled' => '<span class="badge bg-dark">Cancelled</span>',
            'coming_soon' => '<span class="badge bg-primary">Coming Soon</span>',
            'price_reduced' => '<span class="badge bg-success">Price Reduced</span>'
        ];
        
        return $statusBadges[$status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }
}