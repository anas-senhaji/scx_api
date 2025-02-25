<?php

namespace App\Modules\Tournament\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CustomResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Modules\Tournament\Models\Tournament;
use App\Modules\Tournament\Services\TournamentService;


class TournamentController extends Controller
{

    use CustomResponse;
    protected $tournamentService;

    public function __construct(TournamentService $tournamentService)
    {
        $this->tournamentService = $tournamentService;
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'picture' => 'nullable',
            'tournament_type_id' => 'required|string',
            'event_id' => 'nullable',
        ]);
        // Check if the request has a validator property and if it has failed
        if (isset($validator) && $validator->fails())
            return $this->jsonResponse(false, 400, 400, $validator->messages(), 'Erreur Bad Request');

        $data = $validator->validated();
        return $this->tournamentService->create($data);
    }

    public function update(Tournament $tournament, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'tournament_type_id' => 'required|string',
            'event_id' => 'required|string',
        ]);
        // Check if the request has a validator property and if it has failed
        if (isset($validator) && $validator->fails())
            return $this->jsonResponse(false, 400, 400, $validator->messages(), 'Erreur Bad Request');
        return $this->tournamentService->create($validator->validated(), $tournament);
    }

    public function delete(Tournament $tournament){
        return $this->tournamentService->delete($tournament);
    }

    public function getOne(Tournament $tournament){
        return $this->tournamentService->getOne($tournament);
    }
    
    public function getAll(Request $request){
        return $this->tournamentService->getAll($request);
    }

    public function assignToTournament(Request $request){
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|string',
            'players' => 'required_without:teams|array',
            'teams' => 'required_without:players|array',
        ]);
        // Check if the request has a validator property and if it has failed
        if (isset($validator) && $validator->fails())
            return $this->jsonResponse(false, 400, 400, $validator->messages(), 'Erreur Bad Request');

        $data = $validator->validated();
        return $this->tournamentService->assignToTournament($data);
    }

    // Tirage au sort
    public function tournamentDraw(Tournament $tournament){
        return $this->tournamentService->tournamentDraw($tournament);
    }
}
