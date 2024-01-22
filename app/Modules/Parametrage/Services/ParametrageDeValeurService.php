<?php

namespace App\Modules\Parametrage\Services;

use Carbon\Carbon;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use App\Modules\Parametrage\Models\TypeConge;
use App\Modules\Parametrage\Models\ParametrageDeValeur;

class ParametrageDeValeurService
{
    use CustomResponse;

    // This function is for (Update & Create)
    public function create($request, $parametrage = null) {

        try {
            // Begin a database transaction
            DB::beginTransaction();
                // Check if the request has a validator property and if it has failed
                if (isset($request->validator) && $request->validator->fails())
                    return $this->jsonResponse(true, 400, 400, $request->validator->messages());
            
                // Update or Create a new ParametrageDeValeur model instance with the validated request data
                if($parametrage){
                    $parametrage->update($request->validated());
                    $created_parametrage = $parametrage->fresh();
                }else{
                    $created_parametrage = ParametrageDeValeur::create($request->validated());
                }

            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created/fresh ParametrageDeValeur objects
            return $this->jsonResponse(true, 200, 200, $created_parametrage);

        } catch (\Exception $e) {

            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());

        }
        
    }

    public function delete($parametrage){
        $parametrage->delete();
        return $this->jsonResponse(true, 200, 200);
    }

    public function getOne($parametrage){
        return $this->jsonResponse(true, 200, 200, $parametrage);
    }

    public function getAll($paginate = false, $perPage = 10){
        // If pagination is requested, return a paginated JSON response
        if($paginate){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, ParametrageDeValeur::paginate($perPage));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, ParametrageDeValeur::all());
    }
}