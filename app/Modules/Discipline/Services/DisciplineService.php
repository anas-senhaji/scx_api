<?php

namespace App\Modules\Discipline\Services;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Modules\Discipline\Models\Discipline;
use App\Modules\Discipline\Http\Resources\DisciplineResource;
use App\Modules\Discipline\Http\Resources\DisciplineCollection;

class DisciplineService
{
    use CustomResponse;
    
    // This function is for (Update & Create)
    public function create($data, $discipline = null) {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            
                // Update or Create a new Discipline model instance with the validated request data
                if($discipline){
                    $discipline->update($data);
                    $created_discipline = $discipline->fresh();
                }else{
                    $created_discipline = Discipline::create($data);
                }

            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created discipline object
            return $this->jsonResponse(true, 200, 200, new DisciplineResource($created_discipline));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
        
    }

    public function delete($discipline){
        $discipline->delete();
        return $this->jsonResponse(true, 200, 200);
    }

    public function getOne($discipline){
        // Get the relationships for the Discipline model
        $relations = $discipline->relations(true);
        // Retrieve the Discipline model and related models using the specified relations
        $discipline = Discipline::with($relations)->find($discipline->id);
        // Return a JSON response with the retrieved Discipline model or an empty array if it was not found
        return $this->jsonResponse(true, 200, 200, new DisciplineResource($discipline) ?: []);
    }

    public function getAll($request){
        // Get the relationships for the Discipline model
        $relations = Discipline::relations();
        // Build a query with the Discipline model and its relationships
        $query = Discipline::with($relations);
        // If pagination is requested, return a paginated JSON response
        if(isset($request->per_page)){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, new DisciplineCollection($query->paginate($request->per_page)));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, new DisciplineCollection($query->get()));
    }
}