<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationEntityStoreRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\State;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    // Country methods
    public function indexCountries()
    {
        $countries = $this->locationService->getAllCountries();

        return view('admin.master-data.countries.index', compact('countries'));
    }

    public function storeCountry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_name' => 'required|string|max:255|unique:countries',
            'country_code' => 'nullable|string|max:3',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $country = Country::create($request->only(['country_name', 'country_code', 'description']));

        // Clear cache
        $this->locationService->clearCache('all_countries');

        return response()->json(['success' => true, 'country' => $country]);
    }

    public function updateCountry(Request $request, Country $country)
    {
        // Check if it's a status update
        if ($request->has('status')) {
            $country->update(['status' => $request->status]);

            // Clear cache
            $this->locationService->clearCache('all_countries');

            return response()->json(['success' => true, 'country' => $country]);
        }

        $validator = Validator::make($request->all(), [
            'country_name' => 'required|string|max:255|unique:countries,country_name,' . $country->country_id . ',country_id',
            'country_code' => 'nullable|string|max:3',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $country->update($request->only(['country_name', 'country_code', 'description']));

        // Clear cache
        $this->locationService->clearCache('all_countries');

        return response()->json(['success' => true, 'country' => $country]);
    }

    public function destroyCountry(Country $country)
    {
        $country->delete();

        // Clear cache
        $this->locationService->clearCache('all_countries');

        return response()->json(['success' => true]);
    }

    // State methods
    public function indexStates()
    {
        $states = $this->locationService->getStatesWithCountries();
        $countries = $this->locationService->getAllCountries();

        return view('admin.master-data.states.index', compact('states', 'countries'));
    }

    public function storeState(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'state_title' => 'required|string|max:255|unique:state',
            'country_id' => 'required|exists:countries,country_id',
            'state_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $state = State::create($request->only(['state_title', 'country_id', 'state_description']));

        // Clear cache
        $this->locationService->clearCache('states_with_countries');

        return response()->json(['success' => true, 'state' => $state]);
    }

    public function updateState(Request $request, State $state)
    {
        // Check if it's a status update
        if ($request->has('status')) {
            $state->update(['status' => $request->status]);

            // Clear cache
            $this->locationService->clearCache('states_with_countries');

            return response()->json(['success' => true, 'state' => $state]);
        }

        $validator = Validator::make($request->all(), [
            'state_title' => 'required|string|max:255|unique:state,state_title,' . $state->state_id . ',state_id',
            'country_id' => 'required|exists:countries,country_id',
            'state_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $state->update($request->only(['state_title', 'country_id', 'state_description']));

        // Clear cache
        $this->locationService->clearCache('states_with_countries');

        return response()->json(['success' => true, 'state' => $state]);
    }

    public function destroyState(State $state)
    {
        $state->delete();

        // Clear cache
        $this->locationService->clearCache('states_with_countries');

        return response()->json(['success' => true]);
    }

    // District methods
    public function indexDistricts()
    {
        $districts = $this->locationService->getDistrictsWithRelations();
        $states = $this->locationService->getStatesWithCountries();
        $countries = $this->locationService->getAllCountries();

        return view('admin.master-data.districts.index', compact('districts', 'states', 'countries'));
    }

    public function storeDistrict(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'district_title' => 'required|string|max:255|unique:district',
            'state_id' => 'required|exists:state,state_id',
            'district_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $district = District::create($request->only(['district_title', 'state_id', 'district_description']));

        // Load relationships for response
        $district->load(['state', 'state.country']);

        // Clear cache
        $this->locationService->clearCache('districts_with_relations');

        return response()->json(['success' => true, 'district' => $district]);
    }

    public function updateDistrict(Request $request, District $district)
    {
        // Check if it's a status update
        if ($request->has('district_status')) {
            $district->update(['district_status' => $request->district_status]);
            // Load relationships for response
            $district->load(['state', 'state.country']);

            // Clear cache
            $this->locationService->clearCache('districts_with_relations');

            return response()->json(['success' => true, 'district' => $district]);
        }

        $validator = Validator::make($request->all(), [
            'district_title' => 'required|string|max:255|unique:district,district_title,' . $district->districtid . ',districtid',
            'state_id' => 'required|exists:state,state_id',
            'district_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $district->update($request->only(['district_title', 'state_id', 'district_description']));

        // Load relationships for response
        $district->load(['state', 'state.country']);

        // Clear cache
        $this->locationService->clearCache('districts_with_relations');

        return response()->json(['success' => true, 'district' => $district]);
    }

    public function destroyDistrict(District $district)
    {
        $district->delete();

        // Clear cache
        $this->locationService->clearCache('districts_with_relations');

        return response()->json(['success' => true]);
    }

    // City/Taluka methods
    public function indexCities()
    {
        $cities = $this->locationService->getCitiesWithRelations();
        $districts = $this->locationService->getDistrictsWithRelations();
        $states = $this->locationService->getStatesWithCountries();
        $countries = $this->locationService->getAllCountries();

        return view('admin.master-data.cities.index', compact('cities', 'districts', 'states', 'countries'));
    }

    public function storeCity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:city',
            'districtid' => 'required|exists:district,districtid',
            'state_id' => 'required|exists:state,state_id',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $city = City::create($request->only(['name', 'districtid', 'state_id', 'description']));

        // Load relationships for response
        $city->load(['district', 'state', 'state.country']);

        // Clear cache
        $this->locationService->clearCache('cities_with_relations');

        return response()->json(['success' => true, 'city' => $city]);
    }

    public function updateCity(Request $request, City $city)
    {
        // Check if it's a status update
        if ($request->has('status')) {
            $city->update(['status' => $request->status]);
            // Load relationships for response
            $city->load(['district', 'state', 'state.country']);

            // Clear cache
            $this->locationService->clearCache('cities_with_relations');

            return response()->json(['success' => true, 'city' => $city]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:city,name,' . $city->id,
            'districtid' => 'required|exists:district,districtid',
            'state_id' => 'required|exists:state,state_id',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $city->update($request->only(['name', 'districtid', 'state_id', 'description']));

        // Load relationships for response
        $city->load(['district', 'state', 'state.country']);

        // Clear cache
        $this->locationService->clearCache('cities_with_relations');

        return response()->json(['success' => true, 'city' => $city]);
    }

    public function destroyCity(City $city)
    {
        $city->delete();

        // Clear cache
        $this->locationService->clearCache('cities_with_relations');

        return response()->json(['success' => true]);
    }

    // AJAX methods for cascading dropdowns
    public function getStatesByCountry($countryId)
    {
        $states = $this->locationService->getStatesByCountry($countryId);

        return response()->json($states);
    }

    public function getDistrictsByState($stateId)
    {
        $districts = $this->locationService->getDistrictsByState($stateId);

        return response()->json($districts);
    }

    public function getCitiesByDistrict($districtId)
    {
        $cities = City::where('districtid', $districtId)->get();

        return response()->json($cities);
    }

    // AJAX method for adding new entities
    public function storeEntity(LocationEntityStoreRequest $request)
    {
        $entityType = $request->input('entity_type');
        $name = $request->input('name');
        $description = $request->input('description');

        switch ($entityType) {
            case 'state':
                $entity = State::create([
                    'state_title' => $request->input('name'),
                    'country_id' => $request->input('country_id'),
                    'state_description' => $request->input('description'),
                ]);

                // Clear cache
                $this->locationService->clearCache('states_with_countries');

                break;

            case 'district':
                $entity = District::create([
                    'district_title' => $request->input('name'),
                    'state_id' => $request->input('state_id'),
                    'district_description' => $request->input('description'),
                ]);

                // Load relationships for response
                $entity->load(['state', 'state.country']);

                // Clear cache
                $this->locationService->clearCache('districts_with_relations');

                break;

            case 'city':
                $entity = City::create([
                    'name' => $request->input('name'),
                    'districtid' => $request->input('districtid'),
                    'state_id' => $request->input('state_id'),
                    'description' => $request->input('description'),
                ]);

                // Load relationships for response
                $entity->load(['district', 'state', 'state.country']);

                // Clear cache
                $this->locationService->clearCache('cities_with_relations');

                break;

            default:
                return response()->json(['error' => 'Invalid entity type'], 422);
        }

        return response()->json(['success' => true, 'entity' => $entity, 'entity_type' => $entityType]);
    }
}