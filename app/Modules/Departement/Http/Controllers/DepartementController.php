<?php

namespace App\Modules\Departement\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Departement\Models\Departement;
use App\Modules\Departement\Services\DepartementService;
use App\Modules\Departement\Http\Requests\DepartementRequest;

class DepartementController extends Controller
{

    protected $departementService;

    public function __construct(DepartementService $departementService)
    {
        $this->departementService = $departementService;
    }

    public function create(DepartementRequest $request){
        return $this->departementService->create($request);
    }

    public function update(Departement $departement, DepartementRequest $request){
        return $this->departementService->create($request, $departement);
    }

    public function delete(Departement $departement){
        return $this->departementService->delete($departement);
    }

    public function getOne(Departement $departement){
        return $this->departementService->getOne($departement);
    }
    
    public function getAll(){
        return $this->departementService->getAll();
    }
}
