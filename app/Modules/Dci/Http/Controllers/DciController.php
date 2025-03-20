<?php

namespace App\Modules\Dci\Http\Controllers;

use App\Imports\DcisImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class DciController extends Controller
{
    public function import(Request $request)
    {
        set_time_limit(300);
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new DcisImport, $request->file('file'));
    }
}
