<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BasePropertyApiController;
use App\Models\Property;

use App\Services\DocumentService;
use App\Services\LocationService;
use App\Services\MasterDataService;
use App\Services\PhotoService;
use App\Services\PropertyService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Plot Properties",
 *     description="API Endpoints for Plot Property Management"
 * )
 */

class PlotApiController extends BasePropertyApiController
{
    protected $propertyType = 'plot';
    protected $resourceName = 'plot';
    
    public function __construct(
        PropertyService $propertyService,
        PhotoService $photoService,
        DocumentService $documentService,
        LocationService $locationService,
        MasterDataService $masterDataService
    ) {
        parent::__construct($propertyService, $photoService, $documentService, $locationService, $masterDataService);
    }

    /**
     * @OA\Get(
     *      path="/api/plot",
     *      operationId="getPlotProperties",
     *      tags={"Plot Properties"},
     *      summary="Get list of plot properties",
     *      description="Returns paginated list of plot properties",
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
    public function index(Request $request)
    {
        return parent::index($request);
    }

    /**
     * @OA\Post(
     *      path="/api/plot",
     *      operationId="createPlotProperty",
     *      tags={"Plot Properties"},
     *      summary="Create new plot property",
     *      description="Creates a new plot property",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"owner_name", "contact_number", "size", "village", "taluka_id", "district_id", "state_id", "pincode", "country_id"},
     *                  @OA\Property(property="owner_name", type="string", example="John Doe"),
     *                  @OA\Property(property="contact_number", type="string", example="1234567890"),
     *      @OA\Property(property="size", type="string", example="1000 sq ft"),
     *                  @OA\Property(property="apartment_name", type="string", example="Sunshine Apartments"),
     *                  @OA\Property(property="bhk", type="integer", example=2),
     *                  @OA\Property(property="is_apartment", type="boolean", example=true),
     *                  @OA\Property(property="apartment_floor", type="integer", example=3),
     *                  @OA\Property(property="is_tenament", type="boolean", example=false),
     *                  @OA\Property(property="tenament_floors", type="integer", example=1),
     *                  @OA\Property(property="first_line", type="string", example="123 Main Street"),
     *                  @OA\Property(property="second_line", type="string", example="Apartment 4B"),
     *                  @OA\Property(property="village", type="string", example="Green Valley"),
     *                  @OA\Property(property="taluka_id", type="integer", example=1),
     *                  @OA\Property(property="district_id", type="integer", example=1),
     *                  @OA\Property(property="state_id", type="integer", example=1),
     *                  @OA\Property(property="pincode", type="string", example="123456"),
     *                  @OA\Property(property="country_id", type="integer", example=1),
     *                  @OA\Property(property="status", type="string", example="active"),
     *                  @OA\Property(property="vavetar", type="string", example="Yes"),
     *                  @OA\Property(property="vavetar_name", type="string", example="John Smith"),
     *                  @OA\Property(property="any_issue", type="string", example="No"),
     *                  @OA\Property(property="issue_description", type="string", example=""),
     *                  @OA\Property(property="electric_poll", type="string", example="Yes"),
     *                  @OA\Property(property="electric_poll_count", type="integer", example=2),
     *                  @OA\Property(property="family_issue", type="string", example="No"),
     *                  @OA\Property(property="family_issue_description", type="string", example=""),
     *                  @OA\Property(property="road_distance", type="string", example="500 meters"),
     *                  @OA\Property(property="additional_notes", type="string", example="Near school"),
     *                  @OA\Property(property="amenities", type="array", @OA\Items(type="integer")),
     *                  @OA\Property(property="land_types", type="array", @OA\Items(type="integer")),
     *                  @OA\Property(property="photos", type="array", @OA\Items(type="string", format="binary")),
     *                  @OA\Property(property="documents", type="array", @OA\Items(type="string", format="binary"))
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PropertyResponse")
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
    public function store(Request $request)
    {
        return parent::store($request);
    }

    /**
     * @OA\Get(
     *      path="/api/plot/{id}",
     *      operationId="getPlotProperty",
     *      tags={"Plot Properties"},
     *      summary="Get plot property by ID",
     *      description="Returns a single plot property",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Property ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PropertyResponse")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Property not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
     */
    public function show(Property $property)
    {
        return parent::show($property);
    }

    /**
     * @OA\Put(
     *      path="/api/plot/{id}",
     *      operationId="updatePlotProperty",
     *      tags={"Plot Properties"},
     *      summary="Update plot property",
     *      description="Updates a plot property",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Property ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(property="owner_name", type="string", example="John Doe"),
     *                  @OA\Property(property="contact_number", type="string", example="1234567890"),
     *                  @OA\Property(property="size", type="string", example="1000 sq ft"),
     *                  @OA\Property(property="apartment_name", type="string", example="Sunshine Apartments"),
     *                  @OA\Property(property="bhk", type="integer", example=2),
     *                  @OA\Property(property="is_apartment", type="boolean", example=true),
     *                  @OA\Property(property="apartment_floor", type="integer", example=3),
     *                  @OA\Property(property="is_tenament", type="boolean", example=false),
     *                  @OA\Property(property="tenament_floors", type="integer", example=1),
     *                  @OA\Property(property="first_line", type="string", example="123 Main Street"),
     *                  @OA\Property(property="second_line", type="string", example="Apartment 4B"),
     *                  @OA\Property(property="village", type="string", example="Green Valley"),
     *                  @OA\Property(property="taluka_id", type="integer", example=1),
     *                  @OA\Property(property="district_id", type="integer", example=1),
     *                  @OA\Property(property="state_id", type="integer", example=1),
     *                  @OA\Property(property="pincode", type="string", example="123456"),
     *                  @OA\Property(property="country_id", type="integer", example=1),
     *                  @OA\Property(property="status", type="string", example="active"),
     *                  @OA\Property(property="vavetar", type="string", example="Yes"),
     *                  @OA\Property(property="vavetar_name", type="string", example="John Smith"),
     *                  @OA\Property(property="any_issue", type="string", example="No"),
     *                  @OA\Property(property="issue_description", type="string", example=""),
     *                  @OA\Property(property="electric_poll", type="string", example="Yes"),
     *                  @OA\Property(property="electric_poll_count", type="integer", example=2),
     *                  @OA\Property(property="family_issue", type="string", example="No"),
     *                  @OA\Property(property="family_issue_description", type="string", example=""),
     *                  @OA\Property(property="road_distance", type="string", example="500 meters"),
     *                  @OA\Property(property="additional_notes", type="string", example="Near school"),
     *                  @OA\Property(property="amenities", type="array", @OA\Items(type="integer")),
     *                  @OA\Property(property="land_types", type="array", @OA\Items(type="integer")),
     *                  @OA\Property(property="photos", type="array", @OA\Items(type="string", format="binary"))
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PropertyResponse")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Property not found"
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
    public function update(Request $request, Property $property)
    {
        return parent::update($request, $property);
    }

    /**
     * @OA\Delete(
     *      path="/api/plot/{id}",
     *      operationId="deletePlotProperty",
     *      tags={"Plot Properties"},
     *      summary="Delete plot property",
     *      description="Deletes a plot property",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Property ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Property deleted successfully")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Property not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
     */
    public function destroy(Property $property)
    {
        return parent::destroy($property);
    }

    /**
     * @OA\Get(
     *      path="/api/plot/{property}/states/{countryId}",
     *      operationId="getStatesByCountryForPlot",
     *      tags={"Plot Properties"},
     *      summary="Get states by country for plot property",
     *      description="Returns states for a specific country",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="countryId",
     *          in="path",
     *          description="Country ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="Gujarat"),
     *                      @OA\Property(property="country_id", type="integer", example=1)
     *                  )
     *              )
     *          )
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
        return parent::getStatesByCountry($countryId);
    }

    /**
     * @OA\Get(
     *      path="/api/plot/{property}/districts/{stateId}",
     *      operationId="getDistrictsByStateForPlot",
     *      tags={"Plot Properties"},
     *      summary="Get districts by state for plot property",
     *      description="Returns districts for a specific state",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="stateId",
     *          in="path",
     *          description="State ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="Ahmedabad"),
     *                      @OA\Property(property="state_id", type="integer", example=1)
     *                  )
     *              )
     *          )
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
        return parent::getDistrictsByState($stateId);
    }

    /**
     * @OA\Get(
     *      path="/api/plot/{property}/talukas/{districtId}",
     *      operationId="getTalukasByDistrictForPlot",
     *      tags={"Plot Properties"},
     *      summary="Get talukas by district for plot property",
     *      description="Returns talukas for a specific district",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="districtId",
     *          in="path",
     *          description="District ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="Ahmedabad City"),
     *                      @OA\Property(property="district_id", type="integer", example=1)
     *                  )
     *              )
     *          )
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
    public function getTalukasByDistrict($districtId)
    {
        return parent::getTalukasByDistrict($districtId);
    }

    /**
     * @OA\Post(
     *      path="/api/plot/{property}/amenities",
     *      operationId="storeAmenityForPlot",
     *      tags={"Plot Properties"},
     *      summary="Store amenity for plot property",
     *      description="Creates a new amenity",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Swimming Pool")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Amenity created successfully"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="Swimming Pool"),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
     *              )
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
        return parent::storeAmenity($request);
    }

    /**
     * @OA\Post(
     *      path="/api/plot/{property}/land-types",
     *      operationId="storeLandTypeForPlot",
     *      tags={"Plot Properties"},
     *      summary="Store land type for plot property",
     *      description="Creates a new land type",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Agricultural")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Land type created successfully"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="Agricultural"),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
     *              )
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
        return parent::storeLandType($request);
    }

    /**
     * @OA\Post(
     *      path="/api/plot/{property}/photo-positions",
     *      operationId="updatePhotoPositionsForPlot",
     *      tags={"Plot Properties"},
     *      summary="Update photo positions for plot property",
     *      description="Updates the order of photos for a property",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"positions"},
     *              @OA\Property(
     *                  property="positions",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="index", type="integer", example=0),
     *                      @OA\Property(property="newIndex", type="integer", example=1)
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Photo positions updated successfully")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Property not found"
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
    public function updatePhotoPositions(Request $request, Property $property)
    {
        return parent::updatePhotoPositions($request, $property);
    }

    /**
     * @OA\Delete(
     *      path="/api/plot/{property}/photos/{photoIndex}",
     *      operationId="deletePhotoForPlot",
     *      tags={"Plot Properties"},
     *      summary="Delete photo for plot property",
     *      description="Deletes a specific photo from a property",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="photoIndex",
     *          in="path",
     *          description="Photo index",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Photo deleted successfully")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Property not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
     */
    public function deletePhoto(Request $request, Property $property, $photoIndex)
    {
        return parent::deletePhoto($request, $property, $photoIndex);
    }

    /**
     * @OA\Patch(
     *      path="/api/plot/{property}/update-status",
     *      operationId="updateStatusForPlot",
     *      tags={"Plot Properties"},
     *      summary="Update status for plot property",
     *      description="Updates the status of a plot property",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"status"},
     *              @OA\Property(
     *                  property="status",
     *                  type="string",
     *                  example="active",
     *                  enum={"active", "inactive", "urgent", "under_offer", "reserved", "sold", "cancelled", "coming_soon", "price_reduced"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Status updated successfully"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="status_text", type="string", example="Active")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Property not found"
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
    public function updateStatus(Request $request, Property $property)
    {
        return parent::updateStatus($request, $property);
    }
}