<?php

namespace App\Modules\Collaborateur\Services;

use App\Helpers\UploadHelper;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use App\Modules\Prime\Models\Prime;
use App\Modules\Collaborateur\Models\Collaborateur;
use App\Modules\Collaborateur\Http\Resources\CollaborateurResource;
use App\Modules\Collaborateur\Http\Resources\CollaborateurCollection;

class CollaborateurService
{
    use CustomResponse;
    
    // This function is for (Update & Create)
    public function create($request, $collaborateur = null) {
        try {
            // Begin a database transaction
            DB::beginTransaction();
                // Check if the request has a validator property and if it has failed
                if (isset($request->validator) && $request->validator->fails())
                    return $this->jsonResponse(true, 400, 400, $request->validator->messages());
            
                // Update or Create a new Collaborateur model instance with the validated request data
                if($collaborateur){
                    $collaborateur->update($request->validated());
                    $created_collaborateur = $collaborateur->fresh();
                }else{
                    $created_collaborateur = Collaborateur::create($request->validated());
                }

                // Check if request has the photo
                if($request->hasFile('photo')){
                    // Upload the photo file using the UploadHelper and get the filename
                    $filename = UploadHelper::uploadFiles($request->file('photo'), 'collaborateurs/photos/'.$created_collaborateur->uuid)[0];
                    // Set the photo filename on the Collaborateur model and save it
                    $created_collaborateur->photo = $filename;
                    $created_collaborateur->save();
                }

                // Check if request has primes and associate the collaborateur with it 
                if(isset($request->primes)){
                    foreach ($request->primes as $key => $value) {
                        $prime = new Prime();
                        $prime->fill(['nom' => $key, 'montant' => $value]);
                        $prime->collaborateur()->associate($created_collaborateur);
                        $prime->save();
                    }
                }

            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created collaborateur object
            return $this->jsonResponse(true, 200, 200, new CollaborateurResource($created_collaborateur));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
        
    }

    public function delete($collaborateur){
        $collaborateur->delete();
        return $this->jsonResponse(true, 200, 200);
    }

    public function getOne($collaborateur){
        // Get the relationships for the Collaborateur model
        $relations = $collaborateur->relations(true);
        // Retrieve the Collaborateur model and related models using the specified relations
        $collaborateur = Collaborateur::with($relations)->find($collaborateur->id);
        // Return a JSON response with the retrieved Collaborateur model or an empty array if it was not found
        return $this->jsonResponse(true, 200, 200, new CollaborateurResource($collaborateur) ?: []);
    }

    public function getAll($request, $paginate = false, $perPage = 6){
        if(isset($request->paginate) && $request->paginate == 'true') $paginate = true;
        // Get the relationships for the Collaborateur model
        $relations = Collaborateur::relations();
        // Build a query with the Collaborateur model and its relationships
        $query = Collaborateur::with($relations);
        // If pagination is requested, return a paginated JSON response
        if($paginate){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, new CollaborateurCollection($query->paginate($perPage)));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, new CollaborateurCollection($query->get()));
    }
}