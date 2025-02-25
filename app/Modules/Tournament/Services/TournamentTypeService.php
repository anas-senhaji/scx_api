<?php

namespace App\Modules\Tournament\Services;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Modules\Tournament\Models\TournamentType;
use App\Modules\Tournament\Http\Resources\TournamentTypeResource;
use App\Modules\Tournament\Http\Resources\TournamentTypeCollection;

class TournamentTypeService
{
    use CustomResponse;
    
    // This function is for (Update & Create)
    public function create($data, $tournamentType = null) {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            
                // Update or Create a new TournamentType model instance with the validated request data
                if($tournamentType){
                    $tournamentType->update($data);
                    $created_tournamentType = $tournamentType->fresh();
                }else{
                    $created_tournamentType = TournamentType::create($data);
                }

            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created tournamentType object
            return $this->jsonResponse(true, 200, 200, new TournamentTypeResource($created_tournamentType));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
        
    }

    public function delete($tournamentType){
        $tournamentType->delete();
        return $this->jsonResponse(true, 200, 200);
    }

    public function getOne($tournamentType){
        // Get the relationships for the TournamentType model
        $relations = $tournamentType->relations(true);
        // Retrieve the TournamentType model and related models using the specified relations
        $tournamentType = TournamentType::with($relations)->find($tournamentType->id);
        // Return a JSON response with the retrieved TournamentType model or an empty array if it was not found
        return $this->jsonResponse(true, 200, 200, new TournamentTypeResource($tournamentType) ?: []);
    }

    public function getAll($request){
        // Get the relationships for the TournamentType model
        $relations = TournamentType::relations();
        // Build a query with the TournamentType model and its relationships
        $query = TournamentType::with($relations);
        // If pagination is requested, return a paginated JSON response
        if(isset($request->per_page)){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, new TournamentTypeCollection($query->paginate($request->per_page)));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, new TournamentTypeCollection($query->get()));
    }
}