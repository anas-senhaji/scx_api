<?php

namespace App\Modules\ULC\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CustomResponse;
use App\Imports\UlcsUmmcsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\ULC\Services\ULCService;

class ULCController extends Controller
{

    use CustomResponse;
    protected $ulcService;

    public function __construct(ULCService $ulcService)
    {
        $this->ulcService = $ulcService;
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new UlcsUmmcsImport, $request->file('file'));
    }

    public function getAll(Request $request){
        return $this->ulcService->getAll($request);
    }
}
