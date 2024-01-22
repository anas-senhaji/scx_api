<?php

namespace App\Modules\Groupe\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Groupe\Models\Groupe;
use App\Modules\Groupe\Services\GroupeService;
use App\Modules\Groupe\Http\Requests\GroupeRequest;

class GroupeController extends Controller
{

    protected $groupeService;

    public function __construct(GroupeService $groupeService)
    {
        $this->groupeService = $groupeService;
    }

    public function create(GroupeRequest $request){
        return $this->groupeService->create($request);
    }

    public function update(Groupe $groupe, GroupeRequest $request){
        return $this->groupeService->create($request, $groupe);
    }

    public function delete(Groupe $groupe){
        return $this->groupeService->delete($groupe);
    }

    public function getOne(Groupe $groupe){
        return $this->groupeService->getOne($groupe);
    }
    
    public function getAll(){
        return $this->groupeService->getAll();
    }
}
