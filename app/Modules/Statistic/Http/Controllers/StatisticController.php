<?php

namespace App\Modules\Statistic\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CustomResponse;
use App\Modules\UMMC\Models\UMMC;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Modules\Statistic\Models\UlcStatistic;

use App\Modules\Statistic\Models\UmmcStatistic;
use App\Modules\Statistic\Services\StatisticService;

class StatisticController extends Controller
{
    use CustomResponse;
    protected $statisticService;

    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }
    public function import(Request $request)
    {
        return $this->statisticService->import($request);
    }

    public function fetch(Request $request)
    {
        $filters = $request->all();
        $startDate = $filters["start_date"];
        $endDate = $filters["end_date"];
        $type = $filters["type"];
        if($type == 'ulc')
        {

            $query = UlcStatistic::query();

            if ($startDate && $endDate) {
                // Si les deux dates existent, filtrer par intervalle
                $query->whereBetween('date', [$startDate, $endDate]);
            } else {
                // Sinon, récupérer les données du mois en cours
                $query->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
            }

            $data = $query->select(
                'date',
                DB::raw('AVG(taux_peremption) as taux_peremption'),
                DB::raw('AVG(taux_occupation) as taux_occupation'),
                DB::raw('AVG(taux_proche_perimes) as taux_proche_perimes'),
                DB::raw('AVG(taux_rupture) as taux_rupture'),
                DB::raw('AVG(taux_proche_penuerie) as taux_disponibilite_a'),
                DB::raw('AVG(taux_disponibilite_b) as taux_disponibilite_b'),
                DB::raw('AVG(taux_disponibilite_c) as taux_disponibilite_c'),
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
            dd($data);
        }
        else
        {
            $ummcs = UMMC::where('ulc_id', $filters['ulc_id'])->get();
            $query = UmmcStatistic::whereIn('ummc_id', $ummcs->pluck('id'));

            if ($startDate && $endDate) {
                // Si les deux dates existent, filtrer par intervalle
                $query->whereBetween('date', [$startDate, $endDate]);
            } else {
                // Sinon, récupérer les données du mois en cours
                $query->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
            }

            $data = $query->select(
                'date',
                DB::raw('AVG(taux_prescription) as taux_prescription'),
                DB::raw('AVG(taux_adoption) as taux_adoption'),
                DB::raw('AVG(taux_couverture) as taux_couverture'),
                DB::raw('AVG(taux_occupation) as taux_occupation'),
                DB::raw('AVG(taux_peremption) as taux_peremption'),
                DB::raw('AVG(taux_proche_perime) as taux_proche_perime'),
                DB::raw('AVG(taux_rupture) as taux_rupture'),
                DB::raw('AVG(taux_proche_penuerie) as taux_proche_penuerie'),
                DB::raw('AVG(taux_disponibilite_a) as taux_disponibilite_a'),
                DB::raw('AVG(taux_disponibilite_b) as taux_disponibilite_b'),
                DB::raw('AVG(taux_disponibilite_c) as taux_disponibilite_c'),
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
            dd($data);

        }

    }
}
