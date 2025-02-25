<?php

namespace App\Modules\Game\Services;
use App\Traits\CustomResponse;
use App\Modules\Game\Models\Game;
use App\Modules\Team\Models\Team;
use Illuminate\Support\Facades\DB;
use App\Modules\Player\Models\Player;
use Illuminate\Support\Facades\Validator;
use App\Modules\Game\Http\Resources\GameResource;
use App\Modules\Game\Http\Resources\GameCollection;

class GameService
{
    use CustomResponse;
    
    // This function is for (Update & Create)
    public function create($data, $game = null) {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            
                // Update or Create a new Game model instance with the validated request data
                if($game){
                    $game->update($game);
                    $created_game = $game->fresh();
                }else{
                    $created_game = Game::create($data);
                }

            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created game object
            return $this->jsonResponse(true, 200, 200, new GameResource($created_game));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
        
    }
    public function delete($game){
        $game->delete();
        return $this->jsonResponse(true, 200, 200);
    }

    public function getOne($game){
        // Get the relationships for the Game model
        $relations = $game->relations(true);
        // Retrieve the Game model and related models using the specified relations
        $game = Game::with($relations)->find($game->id);
        // Return a JSON response with the retrieved Game model or an empty array if it was not found
        return $this->jsonResponse(true, 200, 200, new GameResource($game) ?: []);
    }

    public function getAll($request){
        // Get the relationships for the Game model
        $relations = Game::relations();
        // Build a query with the Game model and its relationships
        $query = Game::with($relations);
        // If pagination is requested, return a paginated JSON response
        if(isset($request->per_page)){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, new GameCollection($query->paginate($request->per_page)));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, new GameCollection($query->get()));
    }

    public function getAllTeamGames(){
        $games = Game::where('home_type', Team::class)
                 ->orWhere('visiting_type', Team::class)
                 ->with(['home', 'visiting'])
                 ->get();
        
        return $this->jsonResponse(true, 200, 200, new GameCollection($games));
    }

    public function getAllPlayerGames(){
        $games = Game::where('home_type', Player::class)
                 ->orWhere('visiting_type', Player::class)
                 ->with(['home', 'visiting'])
                 ->get();
        
        return $this->jsonResponse(true, 200, 200, new GameCollection($games));
    }
}