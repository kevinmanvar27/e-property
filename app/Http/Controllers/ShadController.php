<?php

namespace App\Http\Controllers;

use App\Services\DocumentService;
use App\Services\LocationService;
use App\Services\MasterDataService;
use App\Services\PhotoService;
use App\Services\PropertyService;

class ShadController extends BasePropertyController
{
    protected $propertyType = 'shad';

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
