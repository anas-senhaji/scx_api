<?php

namespace App\Modules\Player\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CustomResponse;
use App\Http\Controllers\Controller;
use App\Modules\Player\Models\Player;
use Illuminate\Support\Facades\Validator;
use App\Modules\Tournament\Models\Tournament;
use App\Modules\Player\Services\PlayerService;

class PlayerController extends Controller
{

    use CustomResponse;
    protected $playerService;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'birth_date' => 'required|date',
            'gender' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'nickname' => 'string',
            'email' => 'required|string',
            'password' => 'required|string',
            'picture' => 'nullable',
        ]);
        // Check if the request has a validator property and if it has failed
        if (isset($validator) && $validator->fails())
            return $this->jsonResponse(false, 400, 400, $validator->messages(), 'Erreur Bad Request');
        
        return $this->playerService->create($validator->validated());
    }

    public function update(Player $player, Request $request){
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'gender' => 'required|string',
            'country_id' => 'required',
            'email' => 'required|string',
            'password' => 'required|string', 
            'picture' => 'nullable',
        ]);
        // Check if the request has a validator property and if it has failed
        if (isset($validator) && $validator->fails())
            return $this->jsonResponse(false, 400, 400, $validator->messages(), 'Erreur Bad Request');

        return $this->playerService->create($validator->validated(), $player);
    }

    public function delete(Player $player){
        return $this->playerService->delete($player);
    }

    public function getOne(Player $player){
        return $this->playerService->getOne($player);
    }
    
    public function getAll(Request $request){
        return $this->playerService->getAll($request);
    }

    public function getEligiblePlayersForTournament(Tournament $tournament){
        return $this->playerService->getEligiblePlayersForTournament($tournament);
    }
}
