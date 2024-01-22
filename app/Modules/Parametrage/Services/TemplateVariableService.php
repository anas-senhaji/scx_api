<?php

namespace App\Modules\Parametrage\Services;

use Carbon\Carbon;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use App\Modules\Parametrage\Models\TemplateVariable;
use App\Modules\Parametrage\Http\Resources\TemplateVariableResource;
use App\Modules\Parametrage\Http\Resources\TemplateVariableCollection;

class TemplateVariableService
{
    use CustomResponse;
    
    // This function is for (Update & Create)
    public function setVariables($request, $templateVariable = null) {
        try {
            // Begin a database transaction
            DB::beginTransaction();
                // Check if the request has a validator property and if it has failed
                if (isset($request->validator) && $request->validator->fails())
                    return $this->jsonResponse(false, 422, 422, $request->validator->messages());

                $data = $request->validated();
                
                foreach ($data['equivalents'] as $key => $value) {
                    TemplateVariable::where(['id' => $value['variable_id']])->update(['equivalent' => $value['equivalent']]);
                }

                $tamplateVariables = TemplateVariable::where('template_id', $data['template_id'])->get();
                
            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created collaborateur object
            return $this->jsonResponse(true, 200, 200, new TemplateVariableCollection($tamplateVariables));
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