<?php

namespace App\Modules\Dci\Services;
use App\Imports\DcisImport;
use App\Traits\CustomResponse;
use App\Modules\Dci\Models\Dci;
use Illuminate\Support\Facades\DB;
use App\Modules\Dci\Models\DoseDciStat;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DciService
{
    use CustomResponse;
    //

    public function import($request)
    {
        // dd('anas');
        ini_set('max_execution_time', 300); // 5 minutes
ini_set('memory_limit', '512M');    // Increase memory limit

        try {
            // Begin a database transaction
            DB::beginTransaction();

            $request->validate([
                'file' => 'required|mimes:xlsx,csv'
            ]);
            Excel::import(new DcisImport, $request->file('file'));
            
            // Commit the database transaction
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
        
    }

    public function fetch($request)
    {
        $request = $request->all();
        $sortBy = $request['TOP'] ?? 'sortByDesc'; //sortBy or sortByDesc
        $data = DoseDciStat::with('dci')->scopes([
            'ByStartDate' => $request['start_date'] ?? null,
            'ByEndDate' => $request['end_date'] ?? null,
            'ByDci' => $request['dci_id'] ?? null,
            'ByDoseDci' => $request['dose_dcis_id'] ?? null,
            'ByUmmc' => $request['ummc_id'] ?? null
        ])->get();

        $groupedData = $data->groupBy('dci_id')->map(function ($group, $dci_id) {
            return [
                'dci_id' => $dci_id,
                'ummc_id' => optional($group->first())->ummc_id,
                'dci_name' => optional($group->first()->dci)->name,
                'average_consommation' => round($group->avg('consommation'), 2),
                'average_prevision' => round($group->avg('prevision'), 2),
                'average_ecart' => (100 * (round($group->avg('consommation'), 2) - round($group->avg('prevision'), 2)) / round($group->avg('prevision'), 2))
            ];
        })->$sortBy('average_consommation') // Sort by highest average consommation
        ->take(10) // Take the top 10
        ->values();

        return $this->jsonResponse(true, 200, 200, $groupedData);
    }

    public function getDcis(){
        $data = Dci::all();
        return $this->jsonResponse(true, 200, 200, $data);
    }

}