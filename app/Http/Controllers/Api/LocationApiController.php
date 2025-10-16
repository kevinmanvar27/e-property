<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\State;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Country",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="India"),
 *     @OA\Property(property="code", type="string", example="IN"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
 * )
 *
 * @OA\Schema(
 *     schema="State",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Gujarat"),
 *     @OA\Property(property="country_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
 * )
 *
 * @OA\Schema(
 *     schema="District",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Ahmedabad"),
 *     @OA\Property(property="state_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
 * )
 *
 * @OA\Schema(
 *     schema="City",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Ahmedabad City"),
 *     @OA\Property(property="district_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
 * )
 *
 * @OA\Schema(
 *     schema="CountriesResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Country")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="StatesResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/State")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="DistrictsResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/District")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="CitiesResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/City")
 *     )
 * )
 *
 * @OA\Tag(
 *     name="Locations",
 *     description="API Endpoints for Location Management"
 * )
 */

class LocationApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/countries",
     *      operationId="getCountries",
     *      tags={"Locations"},
     *      summary="Get list of countries",
     *      description="Returns list of countries",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CountriesResponse")
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
    public function indexCountries()
    {
        try {
            $countries = Country::all();

            return response()->json([
                'success' => true,
                'data' => $countries,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading countries: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading countries. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/countries",
     *      operationId="createCountry",
     *      tags={"Locations"},
     *      summary="Create new country",
     *      description="Creates a new country",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","code"},
     *              @OA\Property(property="name", type="string", example="India"),
     *              @OA\Property(property="code", type="string", example="IN")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Country created successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/Country")
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
    public function storeCountry(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:countries,name',
                'code' => 'required|string|max:10|unique:countries,code',
            ]);

            $country = Country::create($request->only(['name', 'code']));

            return response()->json([
                'success' => true,
                'message' => 'Country created successfully',
                'data' => $country,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating country: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the country. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/countries/{id}",
     *      operationId="updateCountry",
     *      tags={"Locations"},
     *      summary="Update country",
     *      description="Updates a country",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Country id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","code"},
     *              @OA\Property(property="name", type="string", example="India"),
     *              @OA\Property(property="code", type="string", example="IND")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Country updated successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/Country")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Country not found"
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
    public function updateCountry(Request $request, Country $country)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:countries,name,' . $country->id,
                'code' => 'required|string|max:10|unique:countries,code,' . $country->id,
            ]);

            $country->update($request->only(['name', 'code']));

            return response()->json([
                'success' => true,
                'message' => 'Country updated successfully',
                'data' => $country,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating country: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the country. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/countries/{id}",
     *      operationId="deleteCountry",
     *      tags={"Locations"},
     *      summary="Delete country",
     *      description="Deletes a country",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Country id",
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
     *              @OA\Property(property="message", type="string", example="Country deleted successfully")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Country not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
     */
    public function destroyCountry(Country $country)
    {
        try {
            $country->delete();

            return response()->json([
                'success' => true,
                'message' => 'Country deleted successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting country: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the country. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/states",
     *      operationId="getStates",
     *      tags={"Locations"},
     *      summary="Get list of states",
     *      description="Returns list of states",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/StatesResponse")
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
    public function indexStates()
    {
        try {
            $states = State::with('country')->get();

            return response()->json([
                'success' => true,
                'data' => $states,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading states: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading states. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/states",
     *      operationId="createState",
     *      tags={"Locations"},
     *      summary="Create new state",
     *      description="Creates a new state",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","country_id"},
     *              @OA\Property(property="name", type="string", example="Gujarat"),
     *              @OA\Property(property="country_id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="State created successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/State")
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
    public function storeState(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'country_id' => 'required|exists:countries,id',
            ]);

            $state = State::create($request->only(['name', 'country_id']));

            return response()->json([
                'success' => true,
                'message' => 'State created successfully',
                'data' => $state,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating state: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the state. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/states/{id}",
     *      operationId="updateState",
     *      tags={"Locations"},
     *      summary="Update state",
     *      description="Updates a state",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="State id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","country_id"},
     *              @OA\Property(property="name", type="string", example="Gujarat"),
     *              @OA\Property(property="country_id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="State updated successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/State")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="State not found"
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
    public function updateState(Request $request, State $state)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'country_id' => 'required|exists:countries,id',
            ]);

            $state->update($request->only(['name', 'country_id']));

            return response()->json([
                'success' => true,
                'message' => 'State updated successfully',
                'data' => $state,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating state: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the state. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/states/{id}",
     *      operationId="deleteState",
     *      tags={"Locations"},
     *      summary="Delete state",
     *      description="Deletes a state",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="State id",
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
     *              @OA\Property(property="message", type="string", example="State deleted successfully")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="State not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
     */
    public function destroyState(State $state)
    {
        try {
            $state->delete();

            return response()->json([
                'success' => true,
                'message' => 'State deleted successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting state: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the state. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/districts",
     *      operationId="getDistricts",
     *      tags={"Locations"},
     *      summary="Get list of districts",
     *      description="Returns list of districts",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/DistrictsResponse")
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
    public function indexDistricts()
    {
        try {
            $districts = District::with('state.country')->get();

            return response()->json([
                'success' => true,
                'data' => $districts,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading districts: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading districts. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/districts",
     *      operationId="createDistrict",
     *      tags={"Locations"},
     *      summary="Create new district",
     *      description="Creates a new district",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","state_id"},
     *              @OA\Property(property="name", type="string", example="Ahmedabad"),
     *              @OA\Property(property="state_id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="District created successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/District")
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
    public function storeDistrict(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'state_id' => 'required|exists:states,id',
            ]);

            $district = District::create($request->only(['name', 'state_id']));

            return response()->json([
                'success' => true,
                'message' => 'District created successfully',
                'data' => $district,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating district: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the district. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/districts/{id}",
     *      operationId="updateDistrict",
     *      tags={"Locations"},
     *      summary="Update district",
     *      description="Updates a district",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="District id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","state_id"},
     *              @OA\Property(property="name", type="string", example="Ahmedabad"),
     *              @OA\Property(property="state_id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="District updated successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/District")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="District not found"
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
    public function updateDistrict(Request $request, District $district)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'state_id' => 'required|exists:states,id',
            ]);

            $district->update($request->only(['name', 'state_id']));

            return response()->json([
                'success' => true,
                'message' => 'District updated successfully',
                'data' => $district,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating district: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the district. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/districts/{id}",
     *      operationId="deleteDistrict",
     *      tags={"Locations"},
     *      summary="Delete district",
     *      description="Deletes a district",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="District id",
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
     *              @OA\Property(property="message", type="string", example="District deleted successfully")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="District not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
     */
    public function destroyDistrict(District $district)
    {
        try {
            $district->delete();

            return response()->json([
                'success' => true,
                'message' => 'District deleted successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting district: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the district. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/cities",
     *      operationId="getCities",
     *      tags={"Locations"},
     *      summary="Get list of cities",
     *      description="Returns list of cities",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CitiesResponse")
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
    public function indexCities()
    {
        try {
            $cities = City::with('district.state.country')->get();

            return response()->json([
                'success' => true,
                'data' => $cities,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading cities: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading cities. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/cities",
     *      operationId="createCity",
     *      tags={"Locations"},
     *      summary="Create new city",
     *      description="Creates a new city",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","district_id"},
     *              @OA\Property(property="name", type="string", example="Ahmedabad City"),
     *              @OA\Property(property="district_id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="City created successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/City")
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
    public function storeCity(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'district_id' => 'required|exists:districts,id',
            ]);

            $city = City::create($request->only(['name', 'district_id']));

            return response()->json([
                'success' => true,
                'message' => 'City created successfully',
                'data' => $city,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating city: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the city. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/cities/{id}",
     *      operationId="updateCity",
     *      tags={"Locations"},
     *      summary="Update city",
     *      description="Updates a city",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="City id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","district_id"},
     *              @OA\Property(property="name", type="string", example="Ahmedabad City"),
     *              @OA\Property(property="district_id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="City updated successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/City")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="City not found"
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
    public function updateCity(Request $request, City $city)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'district_id' => 'required|exists:districts,id',
            ]);

            $city->update($request->only(['name', 'district_id']));

            return response()->json([
                'success' => true,
                'message' => 'City updated successfully',
                'data' => $city,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating city: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the city. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/cities/{id}",
     *      operationId="deleteCity",
     *      tags={"Locations"},
     *      summary="Delete city",
     *      description="Deletes a city",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="City id",
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
     *              @OA\Property(property="message", type="string", example="City deleted successfully")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="City not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
     */
    public function destroyCity(City $city)
    {
        try {
            $city->delete();

            return response()->json([
                'success' => true,
                'message' => 'City deleted successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting city: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the city. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/locations/states/{countryId}",
     *      operationId="getStatesByCountry",
     *      tags={"Locations"},
     *      summary="Get states by country",
     *      description="Returns list of states for a specific country",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="countryId",
     *          description="Country id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/StatesResponse")
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
    public function getStatesByCountry($countryId)
    {
        try {
            $states = State::where('country_id', $countryId)
                ->get(['state_id', 'state_title']);

            return response()->json([
                'success' => true,
                'data' => $states,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading states by country: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading states. Please try again.',
            ], 500);
        }
    }


    /**
     * @OA\Get(
     *      path="/api/locations/districts/{stateId}",
     *      operationId="getDistrictsByState",
     *      tags={"Locations"},
     *      summary="Get districts by state",
     *      description="Returns list of districts for a specific state",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="stateId",
     *          description="State id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/DistrictsResponse")
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
    public function getDistrictsByState($stateId)
    {
        try {
            $districts = District::where('state_id', $stateId)->get();

            return response()->json([
                'success' => true,
                'data' => $districts,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading districts by state: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading districts. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/locations/cities/{districtId}",
     *      operationId="getCitiesByDistrict",
     *      tags={"Locations"},
     *      summary="Get cities by district",
     *      description="Returns list of cities for a specific district",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="districtId",
     *          description="District id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CitiesResponse")
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
    public function getCitiesByDistrict($districtId)
    {
        try {
            $cities = City::where('districtid', $districtId)->get();

            return response()->json([
                'success' => true,
                'data' => $cities,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading cities by district: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading cities. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/locations/entities",
     *      operationId="storeEntity",
     *      tags={"Locations"},
     *      summary="Create a new location entity",
     *      description="Creates a new country, state, district, or city",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"type","name"},
     *              @OA\Property(property="type", type="string", example="country", enum={"country","state","district","city"}),
     *              @OA\Property(property="name", type="string", example="India"),
     *              @OA\Property(property="country_id", type="integer", example=1),
     *              @OA\Property(property="state_id", type="integer", example=1),
     *              @OA\Property(property="district_id", type="integer", example=1),
     *              @OA\Property(property="code", type="string", example="IN")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Country created successfully"),
     *              @OA\Property(property="data", type="object")
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
    public function storeEntity(Request $request)
    {
        try {
            $request->validate([
                'type' => 'required|string|in:country,state,district,city',
                'name' => 'required|string|max:255',
                'country_id' => 'nullable|exists:countries,id',
                'state_id' => 'nullable|exists:states,id',
                'district_id' => 'nullable|exists:districts,id',
                'code' => 'nullable|string|max:10', // For countries
            ]);

            $entity = null;
            switch ($request->type) {
                case 'country':
                    $request->validate(['code' => 'required|string|max:10|unique:countries,code']);
                    $entity = Country::create($request->only(['name', 'code']));

                    break;
                case 'state':
                    $request->validate(['country_id' => 'required|exists:countries,id']);
                    $entity = State::create($request->only(['name', 'country_id']));

                    break;
                case 'district':
                    $request->validate(['state_id' => 'required|exists:states,id']);
                    $entity = District::create($request->only(['name', 'state_id']));

                    break;
                case 'city':
                    $request->validate(['district_id' => 'required|exists:districts,id']);
                    $entity = City::create($request->only(['name', 'district_id']));

                    break;
            }

            return response()->json([
                'success' => true,
                'message' => ucfirst($request->type) . ' created successfully',
                'data' => $entity,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating entity: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the entity. Please try again.',
            ], 500);
        }
    }
}
