<?php

namespace App\Modules\Tournament\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CustomResponse;
use App\Http\Controllers\Controller;
use App\Modules\Tournament\Models\TournamentType;
use App\Modules\Tournament\Services\TournamentTypeService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

class TournamentTypeController extends Controller
{
    use CustomResponse;
    protected $tournamentTypeService;

    public function __construct(TournamentTypeService $tournamentTypeService)
    {
        $this->tournamentTypeService = $tournamentTypeService;
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
            'nbr_player' => 'required|integer', 
            'gender' => 'required|string', 
        ]);
        // Check if the request has a validator property and if it has failed
        if (isset($validator) && $validator->fails())
            return $this->jsonResponse(false, 400, 400, $validator->messages(), 'Erreur Bad Request');
        
        return $this->tournamentTypeService->create($validator->validated());
    }

    public function update(TournamentType $tournamentType, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
            'nbr_player' => 'required|integer', 
            'gender' => 'required|string',
        ]);
        // Check if the request has a validator property and if it has failed
        if (isset($validator) && $validator->fails())
            return $this->jsonResponse(false, 400, 400, $validator->messages(), 'Erreur Bad Request');
        return $this->tournamentTypeService->create($validator->validated(), $tournamentType);
    }

    public function delete(TournamentType $tournamentType){
        return $this->tournamentTypeService->delete($tournamentType);
    }

    public function getOne(TournamentType $tournamentType){
        return $this->tournamentTypeService->getOne($tournamentType);
    }
    
    public function getAll(Request $request){
        return $this->tournamentTypeService->getAll($request);
    }
}
