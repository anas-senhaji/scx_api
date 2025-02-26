<?php

namespace App\Modules\ULC\Services;
use App\Traits\CustomResponse;
use App\Modules\ULC\Models\ULC;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Modules\ULC\Http\Resources\ULCResource;
use App\Modules\ULC\Http\Resources\ULCCollection;

class ULCService
{
    use CustomResponse;

    public function getAll($request, $perPage = 10){
        // Get the relationships for the Tournament model
        $relations = ULC::relations();
        // Build a query with the Tournament model and its relationships
        $query = ULC::with($relations);
        // If pagination is requested, return a paginated JSON response
        if(isset($request->paginate)){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, new ULCCollection($query->paginate($perPage)));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, new ULCCollection($query->get()));
    }
}