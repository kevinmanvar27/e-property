<?php

namespace App\Services;

use App\Models\Property;
use App\Models\Amenity;
use App\Models\LandType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class PropertyService
{
    /**
     * Get cached countries list
     */
    public function getCountries()
    {
        return Cache::remember('countries_list', 3600, function () {
            return \App\Models\Country::pluck('country_name', 'country_id');
        });
    }
    
    /**
     * Get cached states list
     */
    public function getStates()
    {
        return Cache::remember('states_list', 3600, function () {
            return \App\Models\State::pluck('state_title', 'state_id');
        });
    }
    
    /**
     * Get cached districts list by state
     */
    public function getDistrictsByState($stateId)
    {
        return Cache::remember('districts_list_' . $stateId, 3600, function () use ($stateId) {
            return \App\Models\District::where('state_id', $stateId)->pluck('district_name', 'districtid');
        });
    }
    
    /**
     * Get cached talukas list by district
     */
    public function getTalukasByDistrict($districtId)
    {
        return Cache::remember('talukas_list_' . $districtId, 3600, function () use ($districtId) {
            return \App\Models\City::where('district_id', $districtId)->pluck('city_name', 'id');
        });
    }
    
    /**
     * Get cached amenities list
     */
    public function getAmenities()
    {
        return Cache::remember('amenities_list', 3600, function () {
            return Amenity::select('id', 'name')->get();
        });
    }
    
    /**
     * Get cached land types list
     */
    public function getLandTypes()
    {
        return Cache::remember('land_types_list', 3600, function () {
            return LandType::select('id', 'name')->get();
        });
    }
    
    /**
     * Handle document upload
     */
    public function handleDocumentUpload($document, $prefix)
    {
        if ($document) {
            $filename = $prefix . '_' . time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('assets/documents'), $filename);
            return $filename;
        }
        return null;
    }
    
    /**
     * Handle photo uploads
     */
    public function handlePhotoUploads($photos, $existingPhotos = [])
    {
        $photoPaths = $existingPhotos;
        
        if ($photos) {
            foreach ($photos as $index => $photo) {
                $filename = 'photo_' . time() . '_' . $index . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('assets/images/properties'), $filename);
                $photoPaths[] = $filename;
            }
        }
        
        return $photoPaths;
    }
    
    /**
     * Delete property files
     */
    public function deletePropertyFiles(Property $property)
    {
        // Delete associated documents
        if ($property->document_7_12 && file_exists(public_path('assets/documents/' . $property->document_7_12))) {
            unlink(public_path('assets/documents/' . $property->document_7_12));
        }
        
        if ($property->document_8a && file_exists(public_path('assets/documents/' . $property->document_8a))) {
            unlink(public_path('assets/documents/' . $property->document_8a));
        }
        
        // Delete photo files
        if ($property->photos) {
            $photos = json_decode($property->photos, true);
            foreach ($photos as $photo) {
                if (file_exists(public_path('assets/images/properties/' . $photo))) {
                    unlink(public_path('assets/images/properties/' . $photo));
                }
            }
        }
    }
}