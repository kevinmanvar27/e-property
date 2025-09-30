<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Amenity;
use App\Models\LandType;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $propertyType = $request->is('admin/plot*') ? 'plot' : ($request->is('admin/shad*') ? 'shad' : ($request->is('admin/shop*') ? 'shop' : ($request->is('admin/house*') ? 'house' : 'land_jamin')));
        
        // Temporarily disable caching for debugging
        $properties = Property::with(['state', 'district', 'taluka'])
            ->where('property_type', $propertyType)
            ->select(['id', 'owner_name', 'village', 'taluka_id', 'district_id', 'state_id', 'status', 'property_type', 'created_at'])
            ->get();
            
        // Debug: Log the properties count and type
        \Log::info('Shop properties count: ' . $properties->count());
        \Log::info('Property type detected: ' . $propertyType);
        
        if ($propertyType === 'plot') {
            return view('admin.plot.index', compact('properties'));
        } elseif ($propertyType === 'shad') {
            return view('admin.shad.index', compact('properties'));
        } elseif ($propertyType === 'shop') {
            return view('admin.shop.index', compact('properties'));
        } elseif ($propertyType === 'house') {
            return view('admin.house.index', compact('properties'));
        }
        
        return view('admin.land-jamin.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $propertyType = $request->is('admin/plot*') ? 'plot' : ($request->is('admin/shad*') ? 'shad' : ($request->is('admin/shop*') ? 'shop' : ($request->is('admin/house*') ? 'house' : 'land_jamin')));
        
        // Use caching for better performance
        $countries = Cache::remember('countries_list', 3600, function () {
            return Country::pluck('country_name', 'country_id');
        });
        
        $states = Cache::remember('states_list', 3600, function () {
            return State::pluck('state_title', 'state_id');
        });
        
        $amenities = Cache::remember('amenities_list', 3600, function () {
            return Amenity::select('id', 'name')->get();
        });
        
        $landTypes = Cache::remember('land_types_list', 3600, function () {
            return LandType::select('id', 'name')->get();
        });
        
        if ($propertyType === 'plot') {
            return view('admin.plot.create', compact('countries', 'states', 'amenities', 'landTypes'));
        } elseif ($propertyType === 'shad') {
            return view('admin.shad.create', compact('countries', 'states', 'amenities', 'landTypes'));
        } elseif ($propertyType === 'shop') {
            return view('admin.shop.create', compact('countries', 'states', 'amenities', 'landTypes'));
        } elseif ($propertyType === 'house') {
            return view('admin.house.create', compact('countries', 'states', 'amenities', 'landTypes'));
        }
        
        return view('admin.land-jamin.create', compact('countries', 'states', 'amenities', 'landTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Check if the request exceeds PHP's post_max_size
            $postMaxSize = ini_get('post_max_size');
            $unit = strtolower(substr($postMaxSize, -1));
            $value = (int) $postMaxSize;
            
            switch($unit) {
                case 'g':
                    $value *= 1024; // Fall through
                case 'm':
                    $value *= 1024; // Fall through
                case 'k':
                    $value *= 1024;
            }
            
            if ($request->server('CONTENT_LENGTH') > $value) {
                return response()->json([
                    'errors' => [
                        'general' => ['The uploaded files are too large. Please reduce the file sizes and try again. Current limit is 100MB per file.']
                    ]
                ], 413);
            }

            // Determine if this is for plot, land/jamin, or shad to set appropriate validation rules
            $propertyType = $request->is('admin/plot*') ? 'plot' : ($request->is('admin/shad*') ? 'shad' : ($request->is('admin/shop*') ? 'shop' : 'land_jamin'));
            
            $validationRules = [
                'owner_name' => 'required|string|max:255',
                'contact_number' => 'nullable|string|max:15',
                'size' => 'nullable|numeric|min:0', // For shad properties
                'apartment_name' => 'nullable|string|max:255',
                'bhk' => 'nullable|integer|min:0',
                'is_apartment' => 'nullable|string|in:yes,no',
                'apartment_floor' => 'nullable|integer|min:0',
                'is_tenament' => 'nullable|string|in:yes,no',
                'tenament_floors' => 'nullable|integer|min:0',
                'first_line' => 'required|string|max:255',
                'second_line' => 'nullable|string|max:255',
                'village' => 'required|string|max:255',
                'taluka_id' => 'nullable|exists:city,id',
                'district_id' => 'required|exists:district,districtid',
                'state_id' => 'required|exists:state,state_id',
                'pincode' => 'required|string|max:10',
                'country_id' => 'required|exists:countries,country_id',
                'property_type' => 'required|string|in:land_jamin,plot,shad,shop,house',
                'status' => 'nullable|string|in:active,inactive,urgent,under_offer,reserved,sold,cancelled,coming_soon,price_reduced',
                'vavetar' => 'nullable|in:Yes,No',
                'any_issue' => 'nullable|in:Yes,No',
                'issue_description' => 'nullable|string|max:500',
                'electric_poll' => 'nullable|in:Yes,No',
                'electric_poll_count' => 'nullable|integer|min:1',
                'family_issue' => 'nullable|in:Yes,No',
                'family_issue_description' => 'nullable|string|max:500',
                'road_distance' => 'nullable|numeric|min:0|max:999999.99',
                'additional_notes' => 'nullable|string',
                'amenities' => 'nullable|array',
                'amenities.*' => 'exists:amenities,id',
                'land_types' => 'nullable|array',
                'land_types.*' => 'exists:land_types,id',
            ];
            
            // Only add document validation for land/jamin, not for plot
            if ($propertyType !== 'plot') {
                $validationRules['document_7_12'] = 'nullable|file|mimes:pdf,jpg,png|max:102400'; // 100MB
                $validationRules['document_8a'] = 'nullable|file|mimes:pdf,jpg,png|max:102400'; // 100MB
            }
            
            // Always allow photos
            $validationRules['photos'] = 'nullable|array';
            $validationRules['photos.*'] = 'file|mimes:jpg,jpeg,png|max:102400'; // 100MB

            $validator = Validator::make($request->all(), $validationRules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
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

            // Handle document uploads (only for land/jamin)
            if ($propertyType !== 'plot') {
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
            }

            // Create property with JSON data
            $property = Property::create($data);
            
            // Store amenities as JSON
            if ($request->has('amenities')) {
                $property->amenities = $request->amenities;
                $property->save();
            }

            // Store land types as JSON
            if ($request->has('land_types')) {
                $property->land_types = $request->land_types;
                $property->save();
            }

            // Handle photo uploads and store as JSON
            $photos = [];
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
                    
                    $photos[] = [
                        'photo_path' => $filename,
                        'position' => $index,
                    ];
                }
                
                $property->photos = $photos;
                $property->save();
            }

            // Return success without message
            return response()->json(['success' => true, 'property' => $property]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Property store error: ' . $e->getMessage());
            
            // Return a user-friendly error message
            return response()->json([
                'errors' => [
                    'general' => ['An error occurred while saving the property record. Please check that your files are under 100MB and try again.']
                ]
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property, Request $request)
    {
        \Log::info('Property show method called', ['property_id' => $property->id, 'property_type' => $property->property_type]);
        
        // Load relationships for land/jamin properties
        if ($property->property_type !== 'plot') {
            \Log::info('Processing land/jamin property');
            
            // For land/jamin, we need to convert JSON data to objects for the view
            $property->load(['state', 'district', 'taluka', 'country']);
            
            // Create temporary collections for amenities and land types
            $amenityIds = $property->getAmenitiesList();
            $landTypeIds = $property->getLandTypesList();
            
            // Load actual amenity and land type models
            $amenities = Amenity::whereIn('id', $amenityIds)->get();
            $landTypes = LandType::whereIn('id', $landTypeIds)->get();
            
            // Add the collections to the property object
            $property->setRelation('amenities', $amenities);
            $property->setRelation('landTypes', $landTypes);
            
            // For shad properties, we also need to load amenities
            if ($property->property_type === 'shad') {
                $property->load(['state', 'district', 'taluka', 'country']);
                
                // Create temporary collections for amenities and land types
                $amenityIds = $property->getAmenitiesList();
                $landTypeIds = $property->getLandTypesList();
                
                // Load actual amenity and land type models
                $amenities = Amenity::whereIn('id', $amenityIds)->get();
                $landTypes = LandType::whereIn('id', $landTypeIds)->get();
                
                // Add the collections to the property object
                $property->setRelation('amenities', $amenities);
                $property->setRelation('landTypes', $landTypes);
                
                \Log::info('Showing shad property', ['property_id' => $property->id]);
                return view('admin.shad.show', compact('property'));
            }
            
            // For shop properties
            if ($property->property_type === 'shop') {
                $property->load(['state', 'district', 'taluka', 'country']);
                
                // Create temporary collections for amenities and land types
                $amenityIds = $property->getAmenitiesList();
                $landTypeIds = $property->getLandTypesList();
                
                // Load actual amenity and land type models
                $amenities = Amenity::whereIn('id', $amenityIds)->get();
                $landTypes = LandType::whereIn('id', $landTypeIds)->get();
                
                // Add the collections to the property object
                $property->setRelation('amenities', $amenities);
                $property->setRelation('landTypes', $landTypes);
                
                \Log::info('Showing shop property', ['property_id' => $property->id]);
                return view('admin.shop.show', compact('property'));
            }
            
            // For house properties
            if ($property->property_type === 'house') {
                $property->load(['state', 'district', 'taluka', 'country']);
                
                // Create temporary collections for amenities and land types
                $amenityIds = $property->getAmenitiesList();
                $landTypeIds = $property->getLandTypesList();
                
                // Load actual amenity and land type models
                $amenities = Amenity::whereIn('id', $amenityIds)->get();
                $landTypes = LandType::whereIn('id', $landTypeIds)->get();
                
                // Add the collections to the property object
                $property->setRelation('amenities', $amenities);
                $property->setRelation('landTypes', $landTypes);
                
                \Log::info('Showing house property', ['property_id' => $property->id]);
                return view('admin.house.show', compact('property'));
            }
            
            $land = $property; // For compatibility with land-jamin views
            \Log::info('Showing land/jamin property', ['property_id' => $property->id, 'land_variable' => !empty($land)]);
            
            // Add debugging to check if $land is properly set
            \Log::info('Land variable details', [
                'land_id' => $land->id ?? null,
                'land_owner_name' => $land->owner_name ?? null,
                'land_village' => $land->village ?? null
            ]);
            
            return view('admin.land-jamin.show', compact('land'));
        }
        
        // For plot properties
        \Log::info('Processing plot property');
        $property->load(['state', 'district', 'taluka', 'country']);
        return view('admin.plot.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property, Request $request)
    {
        $property = $property->load(['state', 'district', 'taluka']);
        
        $propertyType = $request->is('admin/plot*') ? 'plot' : ($request->is('admin/shad*') ? 'shad' : ($request->is('admin/shop*') ? 'shop' : ($request->is('admin/house*') ? 'house' : 'land_jamin')));
        
        // Use caching for better performance
        $countries = Cache::remember('countries_list', 3600, function () {
            return Country::pluck('country_name', 'country_id');
        });
        
        $states = Cache::remember('states_list', 3600, function () {
            return State::pluck('state_title', 'state_id');
        });
        
        $districts = Cache::remember('districts_list_' . $property->state_id, 3600, function () use ($property) {
            return District::where('state_id', $property->state_id)->pluck('district_title', 'districtid');
        });
        
        $talukas = Cache::remember('talukas_list_' . $property->district_id, 3600, function () use ($property) {
            return City::where('districtid', $property->district_id)->pluck('name', 'id');
        });
        
        $amenities = Cache::remember('amenities_list', 3600, function () {
            return Amenity::select('id', 'name')->get();
        });
        
        $landTypes = Cache::remember('land_types_list', 3600, function () {
            return LandType::select('id', 'name')->get();
        });
        
        // Get selected amenities and land types
        $selectedAmenities = $property->getAmenitiesList();
        $selectedLandTypes = $property->getLandTypesList();
        
        if ($propertyType === 'plot') {
            return view('admin.plot.edit', compact('property', 'countries', 'states', 'districts', 'talukas', 'amenities', 'landTypes', 'selectedAmenities', 'selectedLandTypes'));
        } elseif ($propertyType === 'shad') {
            return view('admin.shad.edit', compact('property', 'countries', 'states', 'districts', 'talukas', 'amenities', 'landTypes', 'selectedAmenities', 'selectedLandTypes'));
        } elseif ($propertyType === 'shop') {
            return view('admin.shop.edit', compact('property', 'countries', 'states', 'districts', 'talukas', 'amenities', 'landTypes', 'selectedAmenities', 'selectedLandTypes'));
        } elseif ($propertyType === 'house') {
            return view('admin.house.edit', compact('property', 'countries', 'states', 'districts', 'talukas', 'amenities', 'landTypes', 'selectedAmenities', 'selectedLandTypes'));
        }
        
        // For land/jamin, use $land variable for consistency with views
        $land = $property;
        return view('admin.land-jamin.edit', compact('land', 'countries', 'states', 'districts', 'talukas', 'amenities', 'landTypes', 'selectedAmenities', 'selectedLandTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        try {
            // Log the incoming request data for debugging
            \Log::info('Property update request data:', $request->all());
            \Log::info('Property update property ID:', ['id' => $property->id]);
            
            // Check if the request exceeds PHP's post_max_size
            if ($request->server('CONTENT_LENGTH') > $this->getPostMaxSize()) {
                \Log::error('Property update error: Request too large', [
                    'content_length' => $request->server('CONTENT_LENGTH'),
                    'post_max_size' => $this->getPostMaxSize()
                ]);
                
                return response()->json([
                    'errors' => [
                        'general' => ['The uploaded files are too large. Please reduce the file sizes and try again. Current limit is 100MB per file.']
                    ]
                ], 413);
            }

            // Determine if this is for plot, land/jamin, or shad to set appropriate validation rules
            $propertyType = $request->is('admin/plot*') ? 'plot' : ($request->is('admin/shad*') ? 'shad' : ($request->is('admin/shop*') ? 'shop' : ($request->is('admin/house*') ? 'house' : 'land_jamin')));
            
            $validationRules = [
                'owner_name' => 'required|string|max:255',
                'contact_number' => 'nullable|string|max:15',
                'size' => 'nullable|numeric|min:0', // For shad properties
                'apartment_name' => 'nullable|string|max:255',
                'bhk' => 'nullable|integer|min:0',
                'is_apartment' => 'nullable|string|in:yes,no',
                'apartment_floor' => 'nullable|integer|min:0',
                'is_tenament' => 'nullable|string|in:yes,no',
                'tenament_floors' => 'nullable|integer|min:0',
                'first_line' => 'required|string|max:255',
                'second_line' => 'nullable|string|max:255',
                'village' => 'required|string|max:255',
                'taluka_id' => 'nullable|exists:city,id',
                'district_id' => 'required|exists:district,districtid',
                'state_id' => 'required|exists:state,state_id',
                'pincode' => 'required|string|max:10',
                'country_id' => 'required|exists:countries,country_id',
                'property_type' => 'required|string|in:land_jamin,plot,shad,shop,house',
                'status' => 'nullable|string|in:active,inactive,urgent,under_offer,reserved,sold,cancelled,coming_soon,price_reduced',
                'vavetar' => 'nullable|in:Yes,No',
                'any_issue' => 'nullable|in:Yes,No',
                'issue_description' => 'nullable|string|max:500',
                'electric_poll' => 'nullable|in:Yes,No',
                'electric_poll_count' => 'nullable|integer|min:1',
                'family_issue' => 'nullable|in:Yes,No',
                'family_issue_description' => 'nullable|string|max:500',
                'road_distance' => 'nullable|numeric|min:0|max:999999.99',
                'additional_notes' => 'nullable|string',
                'amenities' => 'nullable|array',
                'amenities.*' => 'exists:amenities,id',
                'land_types' => 'nullable|array',
                'land_types.*' => 'exists:land_types,id',
            ];
            
            // Only add document validation for land/jamin, not for plot
            if ($propertyType !== 'plot') {
                $validationRules['document_7_12'] = 'nullable|file|mimes:pdf,jpg,png|max:102400'; // 100MB
                $validationRules['document_8a'] = 'nullable|file|mimes:pdf,jpg,png|max:102400'; // 100MB
            }
            
            // Always allow photos
            $validationRules['photos'] = 'nullable|array';
            $validationRules['photos.*'] = 'file|mimes:jpg,jpeg,png|max:102400'; // 100MB

            $validator = Validator::make($request->all(), $validationRules);
            
            // Log validation errors if any
            if ($validator->fails()) {
                \Log::error('Property update validation failed:', $validator->errors()->toArray());
                return response()->json(['errors' => $validator->errors()], 422);
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

            // Handle document uploads (only for land/jamin)
            if ($propertyType !== 'plot') {
                if ($request->hasFile('document_7_12')) {
                    $file = $request->file('document_7_12');
                    // Check if file upload failed due to size limits
                    if (!$file->isValid()) {
                        \Log::error('Property update error: Document 7/12 upload failed');
                        return response()->json([
                            'errors' => [
                                'document_7_12' => ['The 7/12 document is too large or upload failed. Please ensure the file is under 100MB and try again.']
                            ]
                        ], 422);
                    }
                    // Check file size
                    if ($file->getSize() > 102400 * 1024) { // 100MB in bytes (102400 KB * 1024 bytes/KB)
                        \Log::error('Property update error: Document 7/12 too large');
                        return response()->json([
                            'errors' => [
                                'document_7_12' => ['The 7/12 document is too large. Please ensure the file is under 100MB.']
                            ]
                        ], 422);
                    }
                    
                    // Delete old document if exists
                    if ($property->document_7_12 && file_exists(public_path('assets/documents/' . $property->document_7_12))) {
                        unlink(public_path('assets/documents/' . $property->document_7_12));
                    }
                    
                    $filename = 'document_7_12_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/documents'), $filename);
                    $data['document_7_12'] = $filename;
                }

                if ($request->hasFile('document_8a')) {
                    $file = $request->file('document_8a');
                    // Check if file upload failed due to size limits
                    if (!$file->isValid()) {
                        \Log::error('Property update error: Document 8A upload failed');
                        return response()->json([
                            'errors' => [
                                'document_8a' => ['The 8A document is too large or upload failed. Please ensure the file is under 100MB and try again.']
                            ]
                        ], 422);
                    }
                    // Check file size
                    if ($file->getSize() > 102400 * 1024) { // 100MB in bytes (102400 KB * 1024 bytes/KB)
                        \Log::error('Property update error: Document 8A too large');
                        return response()->json([
                            'errors' => [
                                'document_8a' => ['The 8A document is too large. Please ensure the file is under 100MB.']
                            ]
                        ], 422);
                    }
                    
                    // Delete old document if exists
                    if ($property->document_8a && file_exists(public_path('assets/documents/' . $property->document_8a))) {
                        unlink(public_path('assets/documents/' . $property->document_8a));
                    }
                    
                    $filename = 'document_8a_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/documents'), $filename);
                    $data['document_8a'] = $filename;
                }
            }

            $property->update($data);
            \Log::info('Property updated successfully', ['id' => $property->id]);

            // Update amenities JSON
            if ($request->has('amenities')) {
                $property->amenities = $request->amenities;
                $property->save();
            }

            // Update land types JSON
            if ($request->has('land_types')) {
                $property->land_types = $request->land_types;
                $property->save();
            }

            // Handle photo uploads and update photos JSON
            if ($request->hasFile('photos')) {
                $photos = $property->getPhotosList();
                
                foreach ($request->file('photos') as $index => $photo) {
                    // Check if file upload failed due to size limits
                    if (!$photo->isValid()) {
                        \Log::error('Property update error: Photo upload failed');
                        return response()->json([
                            'errors' => [
                                'photos' => ['One or more photos are too large or upload failed. Please ensure each photo is under 100MB and try again.']
                            ]
                        ], 422);
                    }
                    // Check file size
                    if ($photo->getSize() > 102400 * 1024) { // 100MB in bytes (102400 KB * 1024 bytes/KB)
                        \Log::error('Property update error: Photo too large');
                        return response()->json([
                            'errors' => [
                                'photos' => ['One or more photos are too large. Please ensure each photo is under 100MB.']
                            ]
                        ], 422);
                    }
                    $filename = 'photo_' . time() . '_' . $index . '.' . $photo->getClientOriginalExtension();
                    $photo->move(public_path('assets/photos'), $filename);
                    
                    $photos[] = [
                        'photo_path' => $filename,
                        'position' => count($photos),
                    ];
                }
                
                $property->photos = $photos;
                $property->save();
            }

            // Return success without message
            \Log::info('Property update completed successfully', ['id' => $property->id]);
            return response()->json(['success' => true, 'property' => $property]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Property update error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return a user-friendly error message
            return response()->json([
                'errors' => [
                    'general' => ['An error occurred while updating the property record. Please check that your files are under 100MB and try again.']
                ]
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        // Delete documents if they exist (only for land/jamin)
        if ($property->property_type !== 'plot') {
            if ($property->document_7_12 && file_exists(public_path('assets/documents/' . $property->document_7_12))) {
                unlink(public_path('assets/documents/' . $property->document_7_12));
            }
            
            if ($property->document_8a && file_exists(public_path('assets/documents/' . $property->document_8a))) {
                unlink(public_path('assets/documents/' . $property->document_8a));
            }
        }
        
        // Delete photos
        $photos = $property->getPhotosList();
        foreach ($photos as $photo) {
            if (isset($photo['photo_path']) && file_exists(public_path('assets/photos/' . $photo['photo_path']))) {
                unlink(public_path('assets/photos/' . $photo['photo_path']));
            }
        }
        
        // Delete the property record
        $property->delete();

        // Return success without message
        return response()->json(['success' => true]);
    }

    /**
     * Update photo positions
     */
    public function updatePhotoPositions(Request $request, Property $property)
    {
        // For plots, we store photos as JSON, so we don't need to update positions in the database
        // The positions are stored in the JSON array
        // Return success without message
        return response()->json(['success' => true]);
    }

    /**
     * Delete a photo
     */
    public function deletePhoto(Request $request, Property $property, $photoIndex)
    {
        // Get current photos
        $photos = $property->getPhotosList();
        
        // Check if photo index exists
        if (!isset($photos[$photoIndex])) {
            return response()->json(['success' => false, 'message' => 'Photo not found'], 404);
        }
        
        // Get the photo to delete
        $photoToDelete = $photos[$photoIndex];
        
        // Delete the file
        if (isset($photoToDelete['photo_path']) && file_exists(public_path('assets/photos/' . $photoToDelete['photo_path']))) {
            unlink(public_path('assets/photos/' . $photoToDelete['photo_path']));
        }
        
        // Remove the photo from the array
        array_splice($photos, $photoIndex, 1);
        
        // Reindex the array
        $photos = array_values($photos);
        
        // Update the property
        $property->photos = $photos;
        $property->save();
        
        // Return success without message
        return response()->json(['success' => true]);
    }

    /**
     * Get post_max_size in bytes
     */
    protected function getPostMaxSize()
    {
        $postMaxSize = ini_get('post_max_size');
        $unit = strtolower(substr($postMaxSize, -1));
        $value = (int) $postMaxSize;
        
        switch($unit) {
            case 'g':
                $value *= 1024; // Fall through
            case 'm':
                $value *= 1024; // Fall through
            case 'k':
                $value *= 1024;
        }
        
        return $value;
    }

    /**
     * Get districts by state ID
     */
    public function getDistrictsByState($stateId)
    {
        $districts = District::where('state_id', $stateId)->select('districtid', 'district_title')->get();
        return response()->json($districts);
    }

    /**
     * Get talukas by district ID
     */
    public function getTalukasByDistrict($districtId)
    {
        $talukas = City::where('districtid', $districtId)->select('id', 'name')->get();
        return response()->json($talukas);
    }

    /**
     * Get states by country ID
     */
    public function getStatesByCountry($countryId)
    {
        $states = State::where('country_id', $countryId)->select('state_id', 'state_title')->get();
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
     * Update property status
     */
    public function updateStatus(Request $request, Property $property)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|string|in:active,inactive,urgent,under_offer,reserved,sold,cancelled,coming_soon,price_reduced'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $property->status = $request->status;
            $property->save();

            return response()->json([
                'success' => true,
                'status_text' => ucfirst(str_replace('_', ' ', $request->status))
            ]);
        } catch (\Exception $e) {
            \Log::error('Property status update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }
}