<?php

namespace App\Modules\Parametrage\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Parametrage\Models\ParametrageDeValeur;
use App\Modules\Parametrage\Services\ParametrageDeValeurService;
use App\Modules\Parametrage\Http\Requests\ParametrageDeValeurRequest;

class ParametrageDeValeurController extends Controller
{
    protected $parametrageDeValeurService;
    public function __construct(ParametrageDeValeurService $parametrageDeValeurService){
        $this->parametrageDeValeurService = $parametrageDeValeurService;
    }

    public function create(ParametrageDeValeurRequest $request){
        return $this->parametrageDeValeurService->create($request);
    }

    public function update(ParametrageDeValeur $parametrage, ParametrageDeValeurRequest $request){
        return $this->parametrageDeValeurService->create($request, $parametrage);
    }

    public function delete(ParametrageDeValeur $parametrage){
        return $this->parametrageDeValeurService->delete($parametrage);
    }

    public function getOne(ParametrageDeValeur $parametrage){
        return $this->parametrageDeValeurService->getOne($parametrage);
    }
    
    public function getAll(){
        return $this->parametrageDeValeurService->getAll();
    }
}
