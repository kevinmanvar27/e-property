<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BasePropertyApiController;
use App\Models\Property;

use App\Services\DocumentService;
use App\Services\LocationService;
use App\Services\MasterDataService;
use App\Services\PhotoService;
use App\Services\PropertyService;


class LandJaminApiController extends BasePropertyApiController
{
    protected $propertyType = 'land_jamin';
    protected $resourceName = 'land-jamin';
    
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->propertyType = 'land_jamin';
    // }

    public function __construct(
        PropertyService $propertyService,
        PhotoService $photoService,
        DocumentService $documentService,
        LocationService $locationService,
        MasterDataService $masterDataService
    ) {
        parent::__construct($propertyService, $photoService, $documentService, $locationService, $masterDataService);
    }

}
