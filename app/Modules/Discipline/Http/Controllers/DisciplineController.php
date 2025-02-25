<?php

namespace App\Modules\Discipline\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CustomResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Modules\Discipline\Models\Discipline;
use App\Modules\Discipline\Services\DisciplineService;

class DisciplineController extends Controller
{
    use CustomResponse;
    protected $disciplineService;

    public function __construct(DisciplineService $disciplineService)
    {
        $this->disciplineService = $disciplineService;
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
        ]);
        // Check if the request has a validator property and if it has failed
        if (isset($validator) && $validator->fails())
            return $this->jsonResponse(false, 400, 400, $validator->messages(), 'Erreur Bad Request');
        
        return $this->disciplineService->create($validator->validated());
    }

    public function update(Discipline $discipline, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
        ]);
        // Check if the request has a validator property and if it has failed
        if (isset($validator) && $validator->fails())
            return $this->jsonResponse(false, 400, 400, $validator->messages(), 'Erreur Bad Request');
        return $this->disciplineService->create($validator->validated(), $discipline);
    }

    public function delete(Discipline $discipline){
        return $this->disciplineService->delete($discipline);
    }

    public function getOne(Discipline $discipline){
        return $this->disciplineService->getOne($discipline);
    }
    
    public function getAll(Request $request){
        return $this->disciplineService->getAll($request);
    }
}
