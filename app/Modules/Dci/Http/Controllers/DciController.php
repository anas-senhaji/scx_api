<?php

namespace App\Modules\Dci\Http\Controllers;

use App\Imports\DcisImport;
use Illuminate\Http\Request;
use App\Traits\CustomResponse;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Dci\Models\DoseDciStat;
use App\Modules\Dci\Services\DciService;

class DciController extends Controller
{
    use CustomResponse;

    protected $dciService;

    public function __construct(DciService $dciService)
    {
        $this->dciService = $dciService;
    }

    public function import(Request $request)
    {
        return $this->dciService->import($request);
    }

    public function fetch(Request $request)
    {
        return $this->dciService->fetch($request);
    }
    public function getDcis(){
        return $this->dciService->getDcis();
    }
}
