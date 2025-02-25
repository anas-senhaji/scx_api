<?php

namespace App\Modules\Location\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Location\Services\LocationService;

class LocationController extends Controller
{

    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function getAllCountries(){
        return $this->locationService->getAllCountries();
    }
}
