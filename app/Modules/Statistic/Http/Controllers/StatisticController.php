<?php

namespace App\Modules\Statistic\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\CustomResponse;
use App\Modules\ULC\Models\ULC;
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
        $startDate = $filters["start_date"] ?? null;
        $endDate = $filters["end_date"] ?? null;
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
                DB::raw("TO_CHAR(date, 'DD/MM/YYYY') as date"),
                DB::raw('AVG(taux_peremption) as taux_peremption'),
                DB::raw('AVG(taux_occupation) as taux_occupation'),
                DB::raw('AVG(taux_proche_perime) as taux_proche_perime'),
                DB::raw('AVG(taux_rupture) as taux_rupture'),
                DB::raw('AVG(taux_disponibilite_a) as taux_disponibilite_a'),
                DB::raw('AVG(taux_disponibilite_b) as taux_disponibilite_b'),
                DB::raw('AVG(taux_disponibilite_c) as taux_disponibilite_c'),
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
            return $this->jsonResponse(true, 200, 200, $data);
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
                DB::raw("TO_CHAR(date, 'DD/MM/YYYY') as date"),
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
            return $this->jsonResponse(true, 200, 200, $data);

        }

    }

    public function fetchUclTauxByYear(Request $request) {
        // Récupérer les paramètres de la requête
        $filters = $request->all();
        $startDate = $filters["start_date"] ?? null;
        $endDate = $filters["end_date"] ?? null;
        $tauxList = $filters['taux'] ?? [
            'taux_peremption', 'taux_occupation', 'taux_proche_perime', 
            'taux_rupture', 'taux_disponibilite_a', 'taux_disponibilite_b', 'taux_disponibilite_c'
        ];
    
        // Construire la requête pour récupérer les moyennes des taux groupées par mois et par ULC
        $query = UlcStatistic::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('DATE(date) as date, ulc_id') // Grouping by full date
            ->with('ulcs'); // Eager load the related ULC data
    
        foreach ($tauxList as $taux) {
            $query->addSelect(DB::raw("COALESCE(AVG($taux), 0) as $taux"));
        }
    
        // Exécuter la requête et grouper par date et ulc_id
        $data = $query->groupBy('date', 'ulc_id')->orderBy('date', 'asc')->get();
    
        // Organiser les données sous format { date: 'YYYY-MM-DD', ulc: [{ ulc_id: 1, taux_peremption: 2.5, taux_rupture: 1.2, ulc_name: 'ULC A' }] }
        $groupedData = $data->groupBy('date')->map(function ($items, $date) use ($tauxList) {
            return [
                'date' => $date,
                'ulc' => $items->map(function ($item) use ($tauxList) {
                    // Get the ULC name from the relationship
                    $UCL = ULC::find($item->ulc_id); // Since we used `with('ulcs')`, the related ULC should already be loaded.
                    return [
                        'ulc_id' => $item->ulc_id,
                        'ulc_name' => $UCL->name ?? 'Unknown',
                        'ulc_color' => $UCL->color ?? null,
                        ...collect($tauxList)->mapWithKeys(fn ($taux) => [$taux => $item->$taux ?? 0])->toArray(),
                    ];
                })->values(),
            ];
        })->values();

        return $this->jsonResponse(true, 200, 200, $groupedData);
    }
    
    
}
