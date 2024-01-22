<?php

namespace App\Modules\Role\Services;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use App\Modules\Role\Models\Role;

class RoleService
{
    use CustomResponse;
    
    // This function is for (Update & Create)
    public function create($request, $role = null) {
        try {
            // Begin a database transaction
            DB::beginTransaction();
                // Check if the request has a validator property and if it has failed
                if (isset($request->validator) && $request->validator->fails())
                    return $this->jsonResponse(true, 400, 400, $request->validator->messages());
            
                // Update or Create a new Role model instance with the validated request data
                if($role){
                    $role->update($request->validated());
                    $created_role = $role->fresh();
                }else{
                    $created_role = Role::create($request->validated());
                }

            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created role object
            return $this->jsonResponse(true, 200, 200, $created_role);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
        
    }

    public function delete($role){
        $role->delete();
        return $this->jsonResponse(true, 200, 200);
    }

    public function getOne($role){
        // Get the relationships for the Role model
        $relations = $role->relations(true);
        // Retrieve the Role model and related models using the specified relations
        $role = Role::with($relations)->find($role->id);
        // Return a JSON response with the retrieved Role model or an empty array if it was not found
        return $this->jsonResponse(true, 200, 200, $role ?: []);
    }

    public function getAll($paginate = false, $perPage = 10){
        // Get the relationships for the Role model
        $relations = Role::relations();
        // Build a query with the Role model and its relationships
        $query = Role::with($relations);
        // If pagination is requested, return a paginated JSON response
        if($paginate){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, $query->paginate($perPage));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, $query->get());
    }

}