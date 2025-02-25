<?php

namespace App\Modules\Player\Services;
use App\Helpers\UploadHelper;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use App\Modules\Player\Models\Player;
use Illuminate\Support\Facades\Validator;
use App\Modules\Tournament\Models\TournamentType;
use App\Modules\Player\Http\Resources\PlayerResource;
use App\Modules\Player\Http\Resources\PlayerCollection;

class PlayerService
{
    use CustomResponse;
    
    // This function is for (Update & Create)
    public function create($data, $player = null) {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            
                // Update or Create a new Player model instance with the validated request data
                if($player){
                    $player->update($data);
                    $created_player = $player->fresh();
                }else{
                    $created_player = Player::create($data);
                }

                // Check if request has the picture
                if(isset($data['picture'])){
                    // Upload the photo file using the UploadHelper and get the filename
                    $filename = UploadHelper::uploadFiles($data['picture'], 'player/profil/photos/'.$created_player->uuid)[0];
                    // Set the photo filename on the Player model and save it
                    $created_player->picture = $filename;
                    $created_player->save();
                }

            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created player object
            return $this->jsonResponse(true, 200, 200, new PlayerResource($created_player));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
        
    }

    public function delete($player){
        $player->delete();
        return $this->jsonResponse(true, 200, 200);
    }

    public function getOne($player){
        // Get the relationships for the Player model
        $relations = $player->relations(true);
        // Retrieve the Player model and related models using the specified relations
        $player = Player::with($relations)->find($player->id);
        // Return a JSON response with the retrieved Player model or an empty array if it was not found
        return $this->jsonResponse(true, 200, 200, new PlayerResource($player) ?: []);
    }

    public function getAll($request){
        // Get the relationships for the Player model
        $relations = Player::relations();
        // Build a query with the Player model and its relationships
        $query = Player::with($relations);
        // If pagination is requested, return a paginated JSON response
        if(isset($request->per_page)){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, new PlayerCollection($query->paginate($request->per_page)));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, new PlayerCollection($query->get()));
    }

    public function getEligiblePlayersForTournament($tournament){
        // Get the relationships for the Player model
        $relations = Player::relations();

        // Initialize a query builder instance for the Player model. 
        // This allows for chaining additional query constraints or methods specifically for fetching Player data.
        $query = Player::query();
        // Retrieve the gender associated with the tournament type
        $gender = $tournament->tournamentType->gender;
        // Check if the retrieved gender is either 'man' or 'woman'
        if (in_array($gender, ['man', 'woman'])) {
            // If the gender is either 'man' or 'woman', apply it as a condition in the query
            $query->where('gender', $gender);
        }
        // Build a query with the Player model and its relationships
        $query = $query->with($relations);
        // If pagination is requested, return a paginated JSON response
        if(isset($request->per_page)){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, new PlayerCollection($query->paginate($request->per_page)));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, new PlayerCollection($query->get()));
    }
}