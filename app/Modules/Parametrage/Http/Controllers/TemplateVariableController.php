<?php

namespace App\Modules\Parametrage\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Parametrage\Services\TemplateVariableService;
use App\Modules\Parametrage\Http\Requests\TemplateVariableRequest;

class TemplateVariableController extends Controller
{
    protected $templateVariableService;

    public function __construct(TemplateVariableService $templateVariableService){
        $this->templateVariableService = $templateVariableService;
    }

    public function setVariables(TemplateVariableRequest $request){
        return $this->templateVariableService->setVariables($request);
    }
}
