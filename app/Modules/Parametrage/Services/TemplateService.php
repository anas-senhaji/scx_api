<?php

namespace App\Modules\Parametrage\Services;

use Carbon\Carbon;
use App\Helpers\UploadHelper;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Modules\Parametrage\Models\Template;
use App\Modules\Parametrage\Models\TemplateVariable;
use App\Modules\Parametrage\Http\Resources\TemplateResource;

class TemplateService
{
    use CustomResponse;
    
    // This function is for (Update & Create)
    public function create($request, $template = null) {
        try {
            // Begin a database transaction
            DB::beginTransaction();
                // Check if the request has a validator property and if it has failed
                if (isset($request->validator) && $request->validator->fails())
                    return $this->jsonResponse(false, 422, 422, $request->validator->messages());

                $data = $request->validated();

                // Check if request has the file
                if($request->hasFile('file')){
                    // Upload the file using the UploadHelper and get the filename
                    $filename = UploadHelper::uploadFiles($request->file('file'), 'templates/contrat/1')[0];
                    // Set the file filename on the Template model and save it
                    $data['path'] = $filename;
                }

                
                // Charger le modèle de contrat
                $template_file = new TemplateProcessor(public_path('storage/'.$filename));
                $variables = $template_file->getVariables();
                if(count($variables) == 0){
                    return $this->jsonResponse(false, 422, 422, [], 'Merci de definir au moins un variable');
                }
                $created_template = Template::create($data);

                // inserer les variables de modèle
                foreach ($variables as $variable) {
                    TemplateVariable::create([
                        'variable' => $variable,
                        'template_id' => $created_template->id,
                    ]);
                }

            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created collaborateur object
            return $this->jsonResponse(true, 200, 200, new TemplateResource($created_template->load('variables')));
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