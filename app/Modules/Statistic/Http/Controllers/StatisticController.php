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
        $ummc_id = $filters['ummc_id'] ?? null;
        if($ummc_id == null)
        {
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
        else
        {
            $query = UmmcStatistic::where('ummc_id', $ummc_id);
    
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
        $ulc_id = $filters['ulc_id'] ?? null;
        $tauxList = $filters['taux'] ?? [];
    
        $ummc_ids = $ulc_id != null ? UMMC::where('ulc_id', $ulc_id)->pluck('id') : [];
    
        // Construire la requête pour récupérer les moyennes des taux groupées par date et par ULC/UMMC
        $query = $ulc_id == null ? UlcStatistic::whereBetween('date', [$startDate, $endDate])
            ->selectRaw("TO_CHAR(date, 'DD/MM/YYYY') as date, ulc_id")
            ->with('ulcs') 
            : UmmcStatistic::whereBetween('date', [$startDate, $endDate])
            ->selectRaw("TO_CHAR(date, 'DD/MM/YYYY') as date, ummc_id")
            ->whereIn('ummc_id', $ummc_ids)
            ->with('ummcs'); 
    
        foreach ($tauxList as $taux) {
            $query->addSelect(DB::raw("COALESCE(AVG($taux), 0) as $taux"));
        }
    
        // Exécuter la requête et grouper par date et ulc_id ou ummc_id
        $data = $query->groupBy('date', $ulc_id == null ? 'ulc_id' : 'ummc_id')->orderBy('date', 'asc')->get();
    
        // Vérification si toutes les dates sont présentes
        if ($data->isEmpty()) {
            return $this->jsonResponse(true, 200, 200, []);
        }
    
        // Organiser les données par date
        $groupedData = $data->groupBy('date')->map(function ($items, $date) use ($tauxList, $ulc_id) {
            return [
                'date' => $date,
                'entity' => $items->map(function ($item) use ($tauxList, $ulc_id) {
                    // Récupérer l'entité directement depuis la relation chargée
                    $entity = $ulc_id == null ? ULC::find($item->ulc_id) : UMMC::find($item->ummc_id); 
    
                    return [
                        'entity_id' => $ulc_id == null ? $item->ulc_id : $item->ummc_id,
                        'entity_name' => $entity->name ?? 'Unknown',
                        'entity_color' => $entity->color ?? null,
                        ...collect($tauxList)->mapWithKeys(fn ($taux) => [$taux => $item->$taux ?? 0])->toArray(),
                    ];
                })->values(),
            ];
        })->values();
    
        return $this->jsonResponse(true, 200, 200, $groupedData);
    }
    
    
    
}
