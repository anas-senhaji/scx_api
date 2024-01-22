<?php

namespace App\Modules\Parametrage\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Parametrage\Models\WorkflowValidation;
use App\Modules\Parametrage\Services\WorkflowValidationService;
use App\Modules\Parametrage\Http\Requests\WorkflowValidationRequest;

class WorkflowValidationController extends Controller
{
    protected $workflowValidationService;

    public function __construct(WorkflowValidationService $workflowValidationService)
    {
        $this->workflowValidationService = $workflowValidationService;
    }

    public function create(WorkflowValidationRequest $request){
        return $this->workflowValidationService->create($request);
    }

    // public function update(WorkflowValidation $workflow, DepartementRequest $request){
    //     return $this->workflowValidationService->create($request, $workflow);
    // }

    // public function delete(WorkflowValidation $workflow){
    //     return $this->workflowValidationService->delete($workflow);
    // }

    public function getOne(WorkflowValidation $workflow){
        return $this->workflowValidationService->getOne($workflow);
    }
    
    public function getAll(){
        return $this->workflowValidationService->getAll();
    }
}
