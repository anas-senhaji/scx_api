<?php

namespace App\Modules\Collaborateur\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Collaborateur\Models\Collaborateur;
use App\Modules\Collaborateur\Services\CollaborateurService;
use App\Modules\Collaborateur\Http\Requests\CollaborateurRequest;

class CollaborateurController extends Controller
{
    protected $collaborateurService;

    public function __construct(CollaborateurService $collaborateurService)
    {
        $this->collaborateurService = $collaborateurService;
    }

    public function create(CollaborateurRequest $request){
        return $this->collaborateurService->create($request);
    }

    public function update(Collaborateur $collaborateur, CollaborateurRequest $request){
        return $this->collaborateurService->create($request, $collaborateur);
    }

    public function delete(Collaborateur $collaborateur){
        return $this->collaborateurService->delete($collaborateur);
    }

    public function getOne(Collaborateur $collaborateur){
        return $this->collaborateurService->getOne($collaborateur);
    }
    
    public function getAll(Request $request){
        return $this->collaborateurService->getAll($request);
    }
}
