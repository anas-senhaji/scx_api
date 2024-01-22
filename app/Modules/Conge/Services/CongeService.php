<?php

namespace App\Modules\Conge\Services;
use App\Enums\eStatutConge;
use App\Helpers\UploadHelper;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use App\Modules\Conge\Models\Conge;
use Illuminate\Support\Facades\Auth;
use App\Modules\Collaborateur\Models\Collaborateur;
use App\Modules\Parametrage\Models\WorkflowValidationHistorique;

class CongeService
{
    use CustomResponse;
    
    // This function is for (Update & Create)
    public function create($request, $conge = null) {
        try {
            // Begin a database transaction
            DB::beginTransaction();
                // Check if the request has a validator property and if it has failed
                if (isset($request->validator) && $request->validator->fails())
                    return $this->jsonResponse(true, 400, 400, $request->validator->messages());

                $data = $request->validated();

                // If the collaborator id is not set or is null, the id of the collaborateur of authenticated user is used instead
                if(!isset($data['collaborateur_id']) || !$data['collaborateur_id']){
                    $data['collaborateur_id'] = Auth::user()->collaborateur->id;
                }
                
                // Update or Create a new Conge model instance with the validated request data
                if($conge){
                    $conge->update($data);
                    $created_conge = $conge->fresh();
                }else{
                    $created_conge = Conge::create($data);
                }

                // Check if request has the justification
                if($request->hasFile('justification')){
                    $collaborateur = Collaborateur::find($data['collaborateur_id']);
                    // Upload the justification file using the UploadHelper and get the filename
                    $filename = UploadHelper::uploadFiles($request->file('justification'), 'collaborateurs/'.$collaborateur->uuid.'/conges/'.$created_conge->uuid.'/justification')[0];
                    // Set the justification filename on the Collaborateur model and save it
                    $created_conge->justification = $filename;
                    $created_conge->save();
                }

            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created conge object
            return $this->jsonResponse(true, 200, 200, $created_conge);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
        
    }

    public function validateConge($conge, $status){
        try {
            // Begin a database transaction
            DB::beginTransaction();

            if($status == eStatutConge::_EN_ATTENTE){
                // If the status is EN_ATTENTE, set the "niveau_valide" property to 0
                $conge->niveau_valide = 0;
    
            }else{
                // If the status is not EN_ATTENTE, calculate the next level of validation
                $niveau_suivant = $conge->niveau_valide + 1;
                // If the next level of validation is greater than or equal to the number of levels in the workflow and the status is "APPROUVE" (approved)
                if($niveau_suivant >= count($conge->workflow) && $status == eStatutConge::_APPROUVE){
                    // Set the next level of validation to the maximum number of levels
                    $niveau_suivant = count($conge->workflow);
                    // Make status APPROVE (Approved)"
                    $conge->statut = eStatutConge::_APPROUVE;
    
                }elseif($status == eStatutConge::_REJETE){
                    // If the status is "REJETE" (rejected), Make status to REJET (rejected)"
                    $conge->statut = eStatutConge::_REJETE;
    
                }
            }
            // Set the "niveau_valide" property to the calculated next level of validation
            $conge->niveau_valide = $niveau_suivant;
    
            $conge->save();
            // Refresh to get the updated status and level of validation
            $updated_conge = $conge->fresh();
            // Create a new workflow validation history record
            $workflow_validation_historique = new WorkflowValidationHistorique();
            $workflow_validation_historique->collaborateur_id = Auth::user()->collaborateur->id;
            $workflow_validation_historique->statut = $status;
            // Save the workflow validation history record
            $updated_conge->workflowValidationHistoriques()->save($workflow_validation_historique);

            // Commit the transaction
            DB::commit();
            return $this->jsonResponse(true, 200, 200, $updated_conge);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
    }

    public function delete($conge){
        $conge->delete();
        return $this->jsonResponse(true, 200, 200);
    }

    public function getOne($conge){
        // Get the relationships for the Conge model
        $relations = $conge->relations(true);
        // Retrieve the Conge model and related models using the specified relations
        $conge = Conge::with($relations)->find($conge->id);
        // Return a JSON response with the retrieved Conge model or an empty array if it was not found
        return $this->jsonResponse(true, 200, 200, $conge ?: []);
    }

    public function getAll($paginate = false, $perPage = 10){
        // Get the relationships for the Conge model
        $relations = Conge::relations();
        // Build a query with the Conge model and its relationships
        $query = Conge::with($relations);
        // If pagination is requested, return a paginated JSON response
        if($paginate){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, $query->paginate($perPage));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, $query->get());
    }

}