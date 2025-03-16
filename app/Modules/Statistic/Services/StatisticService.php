<?php

namespace App\Modules\Statistic\Services;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UlcUmmcStatisticImport;
use Illuminate\Support\Facades\Validator;
use App\Modules\Statistic\Models\Statistic;
use App\Modules\Statistic\Models\UlcStatistic;
use App\Modules\Statistic\Models\UmmcStatistic;

class StatisticService
{
    use CustomResponse;
    //

    public function import($request)
    {

        try {
            // Begin a database transaction
            DB::beginTransaction();

            if($request->isEcraser == true){
                UmmcStatistic::query()->delete();
                UlcStatistic::query()->delete();
            }
            Excel::import(new UlcUmmcStatisticImport, $request->file('file'));
            
            // Commit the database transaction
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
        
    }
}