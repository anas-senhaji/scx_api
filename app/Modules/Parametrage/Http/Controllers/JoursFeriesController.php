<?php

namespace App\Modules\Parametrage\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Parametrage\Models\JoursFeries;
use App\Modules\Parametrage\Services\JoursFeriesService;
use App\Modules\Parametrage\Http\Requests\JoursFeriesRequest;

class JoursFeriesController extends Controller
{
    protected $joursFeriesService;

    public function __construct(JoursFeriesService $joursFeriesService){
        $this->joursFeriesService = $joursFeriesService;
    }

    public function create(JoursFeriesRequest $request){
        return $this->joursFeriesService->create($request);
    }

    public function update(JoursFeries $joursFeries, JoursFeriesRequest $request){
        return $this->joursFeriesService->create($request, $joursFeries);
    }

    public function delete(JoursFeries $joursFeries){
        return $this->joursFeriesService->delete($joursFeries);
    }

    public function getOne(JoursFeries $joursFeries){
        return $this->joursFeriesService->getOne($joursFeries);
    }
    
    public function getAll(){
        return $this->joursFeriesService->getAll();
    }
}
