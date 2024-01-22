<?php

namespace App\Modules\Conge\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Conge\Models\Conge;
use App\Http\Controllers\Controller;
use App\Modules\Conge\Services\CongeService;
use App\Modules\Conge\Http\Requests\CongeRequest;

class CongeController extends Controller
{

    protected $congeService;

    public function __construct(CongeService $congeService)
    {
        $this->congeService = $congeService;
    }

    public function create(CongeRequest $request){
        return $this->congeService->create($request);
    }

    public function update(Conge $conge, CongeRequest $request){
        return $this->congeService->create($request, $conge);
    }

    public function validateConge(Conge $conge, Request $request){
        return $this->congeService->validateConge($conge, $request->status);
    }

    public function delete(Conge $conge){
        return $this->congeService->delete($conge);
    }

    public function getOne(Conge $conge){
        return $this->congeService->getOne($conge);
    }
    
    public function getAll(){
        return $this->congeService->getAll();
    }
}
