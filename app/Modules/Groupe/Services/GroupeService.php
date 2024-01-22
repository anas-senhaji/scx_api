<?php

namespace App\Modules\Groupe\Services;

use App\Helpers\UploadHelper;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use App\Modules\Groupe\Models\Groupe;

class GroupeService
{
    use CustomResponse;
    
    // This function is for (Update & Create)
    public function create($request, $groupe = null) {
        try {
            // Begin a database transaction
            DB::beginTransaction();
                // Check if the request has a validator property and if it has failed
                if (isset($request->validator) && $request->validator->fails())
                    return $this->jsonResponse(true, 400, 400, $request->validator->messages());
            
                // Update or Create a new Groupe model instance with the validated request data
                if($groupe){
                    $groupe->update($request->validated());
                    $created_groupe = $groupe->fresh();
                }else{
                    $created_groupe = Groupe::create($request->validated());
                }

                // Check if request has the logo
                if($request->hasFile('logo')){
                    // Upload the logo file using the UploadHelper and get the filename
                    $filename = UploadHelper::uploadFiles($request->file('logo'), 'groupes/logos/'.$created_groupe->uuid)[0];
                    // Set the logo filename on the Collaborateur model and save it
                    $created_groupe->logo = $filename;
                    $created_groupe->save();
                }

            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created groupe object
            return $this->jsonResponse(true, 200, 200, $created_groupe);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
        
    }

    public function delete($groupe){
        $groupe->delete();
        return $this->jsonResponse(true, 200, 200);
    }

    public function getOne($groupe){
        // Get the relationships for the Groupe model
        $relations = $groupe->relations(true);
        // Retrieve the Groupe model and related models using the specified relations
        $groupe = Groupe::with($relations)->find($groupe->id);
        // Return a JSON response with the retrieved Groupe model or an empty array if it was not found
        return $this->jsonResponse(true, 200, 200, $groupe ?: []);
    }

    public function getAll($paginate = false, $perPage = 10){
        // Get the relationships for the Groupe model
        $relations = Groupe::relations();
        // Build a query with the Groupe model and its relationships
        $query = Groupe::with($relations);
        // If pagination is requested, return a paginated JSON response
        if($paginate){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, $query->paginate($perPage));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, $query->get());
    }

}