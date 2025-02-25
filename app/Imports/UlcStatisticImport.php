<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Modules\ULC\Models\ULC;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Modules\Statistic\Models\UlcStatistic;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UlcStatisticImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $ulc = ULC::where('name',$row['ulc'])->first();
        return new UlcStatistic([
            'date'  => Carbon::instance(Date::excelToDateTimeObject($row['date']))->format('Y-m-d'),
            'ulc_id' => $ulc->id,
            'stock_image' => $row['image_de_stock'],
            'nbr_produits_perimes' => $row['nbr_de_produits_perimes'],
            'nbr_proche_perimes' => $row['nbr_de_proche_perime'],
            'capacite' => $row['capacite'],
            'taux_occupation' => 100 * $row["taux_doccupation"],
            'taux_peremption' => 100 * $row['taux_de_peremption'],
            'taux_proche_perimes' => 100 * $row['taux_de_proche_perime'],
            'taux_rupture' => trim($row['taux_de_rupture']) == '-' ? NULL : 100 * $row['taux_de_rupture'],
            'taux_proche_penuerie' => trim($row['taux_de_proche_penuerie']) == '-' ? NULL : 100 * $row['taux_de_proche_penuerie'],
            'taux_disponibilite_a' => 100 * $row['taux_de_disponnibilite_a'],
            'taux_disponibilite_b' => 100 * $row['taux_de_disponnibilite_b'],
            'taux_disponibilite_c' => 100 * $row['taux_de_disponnibilite_c']
        ]);
    }
}
