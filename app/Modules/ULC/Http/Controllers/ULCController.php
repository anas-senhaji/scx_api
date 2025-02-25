<?php

namespace App\Modules\ULC\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UlcsUmmcsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ULCController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new UlcsUmmcsImport, $request->file('file'));
    }
}
