<?php

namespace App\Modules\Location\Services;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use App\Modules\Location\Models\Country;
use App\Modules\Location\Models\Location;
use Illuminate\Support\Facades\Validator;

class LocationService
{
    use CustomResponse;
    

    public function getAllCountries($paginate = false, $perPage = 10){
        // Get the relationships for the Country model
        // $relations = Country::relations();
        $relations = [];
        // Build a query with the Country model and its relationships
        $query = Country::with($relations);
        // If pagination is requested, return a paginated JSON response
        if($paginate){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, $query->paginate($perPage));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, $query->get());
    }
}