<?php

namespace App\Modules\Parametrage\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Parametrage\Services\TemplateService;
use App\Modules\Parametrage\Http\Requests\TemplateRequest;

class TemplateController extends Controller
{
    protected $templateService;

    public function __construct(TemplateService $templateService){
        $this->templateService = $templateService;
    }

    public function create(TemplateRequest $request){
        return $this->templateService->create($request);
    }
}
