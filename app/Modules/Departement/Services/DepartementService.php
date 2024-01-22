<?php

namespace App\Modules\Departement\Services;

use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use App\Modules\Departement\Models\Departement;

class DepartementService
{
    use CustomResponse;
    
    // This function is for (Update & Create)
    public function create($request, $departement = null) {
        try {
            // Begin a database transaction
            DB::beginTransaction();
                // Check if the request has a validator property and if it has failed
                if (isset($request->validator) && $request->validator->fails())
                    return $this->jsonResponse(true, 400, 400, $request->validator->messages());
            
                // Update or Create a new Departement model instance with the validated request data
                if($departement){
                    $departement->update($request->validated());
                    $created_departement = $departement->fresh();
                }else{
                    $created_departement = Departement::create($request->validated());
                }

            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created departement object
            return $this->jsonResponse(true, 200, 200, $created_departement);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
        
    }

    public function delete($departement){
        $departement->delete();
        return $this->jsonResponse(true, 200, 200);
    }

    public function getOne($departement){
        // Get the relationships for the Departement model
        $relations = $departement->relations(true);
        // Retrieve the Departement model and related models using the specified relations
        $departement = Departement::with($relations)->find($departement->id);
        // Return a JSON response with the retrieved Departement model or an empty array if it was not found
        return $this->jsonResponse(true, 200, 200, $departement ?: []);
    }

    public function getAll($paginate = false, $perPage = 10){
        // Get the relationships for the Departement model
        $relations = Departement::relations();
        // Build a query with the Departement model and its relationships
        $query = Departement::with($relations);
        // If pagination is requested, return a paginated JSON response
        if($paginate){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, $query->paginate($perPage));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, $query->get());
    }

}