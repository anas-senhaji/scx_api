<?php

namespace App\Modules\Game\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CustomResponse;
use App\Modules\Game\Models\Game;
use App\Modules\Team\Models\Team;
use App\Http\Controllers\Controller;
use App\Modules\Player\Models\Player;
use App\Modules\Game\Services\GameService;

class GameController extends Controller
{

    use CustomResponse;
    protected $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
        ]);
        // Check if the request has a validator property and if it has failed
        if (isset($validator) && $validator->fails())
            return $this->jsonResponse(false, 400, 400, $validator->messages(), 'Erreur Bad Request');
        
        return $this->gameService->create($validator->validated());
    }

    public function update(Game $game, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
        ]);
        // Check if the request has a validator property and if it has failed
        if (isset($validator) && $validator->fails())
            return $this->jsonResponse(false, 400, 400, $validator->messages(), 'Erreur Bad Request');
        return $this->gameService->create($validator->validated(), $game);
    }

    public function delete(Game $game){
        return $this->gameService->delete($game);
    }

    public function getOne(Game $game){
        return $this->gameService->getOne($game);
    }
    
    public function getAll(Request $request){
        return $this->gameService->getAll($request);
    }
    
    public function getAllTeamGames(){
        return $this->gameService->getAllTeamGames();
    }

    public function getAllPlayerGames(){
        return $this->gameService->getAllPlayerGames();
    }
}

