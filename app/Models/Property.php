<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Property extends Model
{
    protected $table = 'properties';
    
    // Enable query caching for better performance
    public $cacheFor = 3600; // Cache for 1 hour
    
    // Configure which attributes should be cast to dates
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    protected $fillable = [
        'owner_name',
        'contact_number',
        'size',
        'apartment_name',
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
        'document_7_12',
        'document_8a',
        'status',
        'property_type',
        'amenities',
        'land_types',
        'photos',
        'bhk',
        'is_apartment',
        'apartment_floor',
        'is_tenament',
        'tenament_floors'
    ];
    
    protected $casts = [
        'amenities' => 'array',
        'land_types' => 'array',
        'photos' => 'array',
        'status' => 'string'
    ];
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Clear cache when a property is created, updated, or deleted
        static::saved(function ($property) {
            Cache::forget("properties_list_{$property->property_type}");
        });
        
        static::deleted(function ($property) {
            Cache::forget("properties_list_{$property->property_type}");
        });
    }
    
    public function taluka()
    {
        return $this->belongsTo(City::class, 'taluka_id');
    }
    
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'districtid');
    }
    
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_id');
    }
    
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    
    // Helper methods to work with JSON data
    public function getAmenitiesList()
    {
        // If amenities is already an array, return it
        if (is_array($this->amenities)) {
            return $this->amenities;
        }
        
        // If amenities is a JSON string, decode it
        if (is_string($this->amenities)) {
            $decoded = json_decode($this->amenities, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        // If amenities is null or any other type, return empty array
        return [];
    }
    
    public function getLandTypesList()
    {
        // If land_types is already an array, return it
        if (is_array($this->land_types)) {
            return $this->land_types;
        }
        
        // If land_types is a JSON string, decode it
        if (is_string($this->land_types)) {
            $decoded = json_decode($this->land_types, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        // If land_types is null or any other type, return empty array
        return [];
    }
    
    public function getPhotosList()
    {
        // If photos is already an array, return it
        if (is_array($this->photos)) {
            return $this->photos;
        }
        
        // If photos is a JSON string, decode it
        if (is_string($this->photos)) {
            $decoded = json_decode($this->photos, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        // If photos is null or any other type, return empty array
        return [];
    }
    
    public function getPropertyTypes()
    {
        return [
            'land_jamin' => 'Land/Jamin',
            'plot' => 'Plot',
            'shad' => 'Shad',
            'shop' => 'Shop',
            'house' => 'House'
        ];
    }
}