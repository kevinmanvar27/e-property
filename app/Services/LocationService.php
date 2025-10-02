<?php

namespace App\Services;

use App\Models\Country;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use Illuminate\Support\Facades\Cache;

class LocationService
{
    protected $propertyService;
    protected $cacheDuration = 1800; // 30 minutes

    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }

    /**
     * Get states by country
     */
    public function getStatesByCountry($countryId)
    {
        return $this->propertyService->getStatesByCountry($countryId);
    }

    /**
     * Get districts by state
     */
    public function getDistrictsByState($stateId)
    {
        return $this->propertyService->getDistrictsByState($stateId);
    }

    /**
     * Get talukas by district
     */
    public function getTalukasByDistrict($districtId)
    {
        return $this->propertyService->getTalukasByDistrict($districtId);
    }

    /**
     * Get cached countries list
     */
    public function getAllCountries()
    {
        return Cache::remember('all_countries', 3600, function () {
            return Country::all();
        });
    }

    /**
     * Get cached states with countries
     */
    public function getStatesWithCountries()
    {
        return Cache::remember('states_with_countries', 3600, function () {
            return State::with('country')->get();
        });
    }

    /**
     * Get cached districts with states and countries
     */
    public function getDistrictsWithRelations()
    {
        return Cache::remember('districts_with_relations', 3600, function () {
            return District::with(['state', 'state.country'])->get();
        });
    }

    /**
     * Get cached cities with relations
     */
    public function getCitiesWithRelations()
    {
        return Cache::remember('cities_with_relations', 3600, function () {
            return City::with(['district', 'state', 'state.country'])->get();
        });
    }

    /**
     * Clear location cache
     */
    public function clearCache($key = null)
    {
        if ($key) {
            Cache::forget($key);
        } else {
            Cache::forget('all_countries');
            Cache::forget('states_with_countries');
            Cache::forget('districts_with_relations');
            Cache::forget('cities_with_relations');
        }
    }
}