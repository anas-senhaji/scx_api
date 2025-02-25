<?php

namespace App\Modules\Statistic\Services;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UlcUmmcStatisticImport;
use Illuminate\Support\Facades\Validator;
use App\Modules\Statistic\Models\Statistic;

class StatisticService
{
    use CustomResponse;
    //

    public function import($request)
    {
        Excel::import(new UlcUmmcStatisticImport, $request->file('file'));
    }
}