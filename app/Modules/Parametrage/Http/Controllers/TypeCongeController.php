<?php

namespace App\Modules\Parametrage\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Parametrage\Models\TypeConge;
use App\Modules\Parametrage\Services\TypeCongeService;
use App\Modules\Parametrage\Http\Requests\TypeCongeRequest;

class TypeCongeController extends Controller
{
    protected $typeCongeService;
    public function __construct(TypeCongeService $typeCongeService){
        $this->typeCongeService = $typeCongeService;
    }

    public function create(TypeCongeRequest $request){
        return $this->typeCongeService->create($request);
    }

    public function update(TypeConge $typeConge, TypeCongeRequest $request){
        return $this->typeCongeService->create($request, $typeConge);
    }

    public function delete(TypeConge $typeConge){
        return $this->typeCongeService->delete($typeConge);
    }

    public function getOne(TypeConge $typeConge){
        return $this->typeCongeService->getOne($typeConge);
    }
    
    public function getAll(){
        return $this->typeCongeService->getAll();
    }
}
