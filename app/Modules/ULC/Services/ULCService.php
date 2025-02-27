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
        // Filter by date range if start_date and end_date are present in the request
        // Filter by date range if start_date and end_date are present in the request
        if ($request->has(['start_date', 'end_date'])) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            // Filter ULCs that have statistics within the date range
            // $query->whereHas('statistics', function ($q) use ($startDate, $endDate) {
            //     $q->whereBetween('date', [$startDate, $endDate]);
            // })
            $query->with(['statistics' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            }]);
            // Load ULCs with UMMCs and their statistics within date range
            $query->with(['ummcs' => function ($q) use ($startDate, $endDate) {
                $q->with(['statistics' => function ($statQ) use ($startDate, $endDate) {
                    $statQ->whereBetween('date', [$startDate, $endDate]);
                }]);
            }]);
            // $query->whereHas('ummcs.statistics', function ($q) use ($startDate, $endDate) {
            //     $q->whereBetween('date', [$startDate, $endDate]);
            // });
        }
        // If pagination is requested, return a paginated JSON response
        if(isset($request->paginate)){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, new ULCCollection($query->paginate($perPage)));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, new ULCCollection($query->get()));
    }
}