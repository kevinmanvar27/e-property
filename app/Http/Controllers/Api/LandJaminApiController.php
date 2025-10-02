<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BasePropertyApiController;
use App\Models\Property;

class LandJaminApiController extends BasePropertyApiController
{
    protected $propertyType = 'land_jamin';
    protected $resourceName = 'land-jamin';
    
    public function __construct()
    {
        parent::__construct();
        $this->propertyType = 'land_jamin';
    }
}
