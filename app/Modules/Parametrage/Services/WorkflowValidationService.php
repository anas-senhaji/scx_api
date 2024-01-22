<?php

namespace App\Modules\Parametrage\Services;

use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use App\Modules\Parametrage\Models\WorkflowValidation;

class WorkflowValidationService
{
    use CustomResponse;
    
    // This function is for (Update & Create)
    public function create($request, $workflow = null) {
        try {
            // Begin a database transaction
            DB::beginTransaction();
                // Check if the request has a validator property and if it has failed
                if (isset($request->validator) && $request->validator->fails())
                    return $this->jsonResponse(true, 400, 400, $request->validator->messages());

                // Update all WorkflowValidations with active = true to active = false
                WorkflowValidation::where(['type' => $request->type, 'active' => true])->update(['active' => false]);
                // Initialize an empty result array
                $result = [];
                foreach($request->workflow as $workflow){
                    $created_workflow = WorkflowValidation::create([
                        'type' => $request->type,
                        'role_id' => isset($workflow['role_id']) ?? null,
                        'user_id' => isset($workflow['user_id']) ?? null,
                        'est_superviseur' => $workflow['est_superviseur'],
                        'niveau' => $workflow['niveau'],
                    ]); 
                    // Add the created WorkflowValidation model to the result array
                    $result[] = $created_workflow;
                }


            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created WorkflowValidation objects
            return $this->jsonResponse(true, 200, 200, $result);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
        
    }

    public function delete($workflow){
        $workflow->delete();
        return $this->jsonResponse(true, 200, 200);
    }

    public function getOne($workflow){
        // Get the relationships for the WorkflowValidation model
        $relations = $workflow->relations(true);
        // Retrieve the WorkflowValidation model and related models using the specified relations
        $workflow = WorkflowValidation::with($relations)->find($workflow->id);
        // Return a JSON response with the retrieved WorkflowValidation model or an empty array if it was not found
        return $this->jsonResponse(true, 200, 200, $workflow ?: []);
    }

    public function getAll($paginate = false, $perPage = 10){
        // If pagination is requested, return a paginated JSON response
        if($paginate){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, WorkflowValidation::paginate($perPage));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, WorkflowValidation::all());
    }

}