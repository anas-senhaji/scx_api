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
            'stock_image' => (empty($row["image_de_stock"]) || trim($row["image_de_stock"]) == '#DIV/0!' || trim($row["image_de_stock"]) == 'infinity%' || trim($row["image_de_stock"]) == '-' || trim($row["image_de_stock"]) == '#N/A') ? NULL : $row['image_de_stock'],
            'nbr_produits_perimes' => (empty($row["nbr_de_produits_perimes"]) || trim($row["nbr_de_produits_perimes"]) == '#DIV/0!' || trim($row["nbr_de_produits_perimes"]) == 'infinity%' || trim($row["nbr_de_produits_perimes"]) == '-' || trim($row["nbr_de_produits_perimes"]) == '#N/A') ? NULL : $row['nbr_de_produits_perimes'],
            'nbr_proche_perimes' => (empty($row["nbr_de_proche_perime"]) || trim($row["nbr_de_proche_perime"]) == '#DIV/0!' || trim($row["nbr_de_proche_perime"]) == 'infinity%' || trim($row["nbr_de_proche_perime"]) == '-' || trim($row["nbr_de_proche_perime"]) == '#N/A') ? NULL : $row['nbr_de_proche_perime'],
            'capacite' => (empty($row["capacite"]) || trim($row["capacite"]) == '#DIV/0!' || trim($row["capacite"]) == 'infinity%' || trim($row["capacite"]) == '-' || trim($row["capacite"]) == '#N/A') ? NULL : $row['capacite'],
            'taux_occupation' => (empty($row["taux_doccupation"]) || trim($row["taux_doccupation"]) == '#DIV/0!' || trim($row["taux_doccupation"]) == 'infinity%' || trim($row["taux_doccupation"]) == '-' || trim($row["taux_doccupation"]) == '#N/A') ? NULL : (100 * $row["taux_doccupation"]),
            'taux_peremption' => (empty($row['taux_de_peremption']) || trim($row['taux_de_peremption']) == '#DIV/0!' || trim($row['taux_de_peremption']) == 'infinity%' || trim($row['taux_de_peremption']) == '-' || trim($row['taux_de_peremption']) == '#N/A') ? NULL : (100 * $row['taux_de_peremption']),
            'taux_proche_perime' => (empty($row['taux_de_proche_perime']) || trim($row['taux_de_proche_perime']) == '#DIV/0!' || trim($row['taux_de_proche_perime']) == 'infinity%' || trim($row['taux_de_proche_perime']) == '-' || trim($row['taux_de_proche_perime']) == '#N/A') ? NULL : (100 * $row['taux_de_proche_perime']),
            'taux_rupture' => (trim($row['taux_de_rupture']) == '-' || empty($row['taux_de_rupture']) || trim($row['taux_de_rupture']) == '#DIV/0!' || trim($row['taux_de_rupture']) == 'infinity%' || trim($row['taux_de_rupture']) == '#N/A') ? NULL : (100 * $row['taux_de_rupture']),
            'taux_proche_penuerie' => (trim($row['taux_de_proche_penuerie']) == '-' || empty($row['taux_de_proche_penuerie']) || trim($row['taux_de_proche_penuerie']) == '#DIV/0!' || trim($row['taux_de_proche_penuerie']) == 'infinity%' || trim($row['taux_de_proche_penuerie']) == '#N/A') ? NULL : (100 * $row['taux_de_proche_penuerie']),
            'taux_disponibilite_a' => (empty($row['taux_de_disponnibilite_a']) || trim($row['taux_de_disponnibilite_a']) == '#DIV/0!' || trim($row['taux_de_disponnibilite_a']) == 'infinity%' || trim($row['taux_de_disponnibilite_a']) == '-' || trim($row['taux_de_disponnibilite_a']) == '#N/A') ? NULL : (100 * $row['taux_de_disponnibilite_a']),
            'taux_disponibilite_b' => (empty($row['taux_de_disponnibilite_b']) || trim($row['taux_de_disponnibilite_b']) == '#DIV/0!' || trim($row['taux_de_disponnibilite_b']) == 'infinity%' || trim($row['taux_de_disponnibilite_b']) == '-' || trim($row['taux_de_disponnibilite_b']) == '#N/A') ? NULL : (100 * $row['taux_de_disponnibilite_b']),
            'taux_disponibilite_c' => (empty($row['taux_de_disponnibilite_c']) || trim($row['taux_de_disponnibilite_c']) == '#DIV/0!' || trim($row['taux_de_disponnibilite_c']) == 'infinity%' || trim($row['taux_de_disponnibilite_c']) == '-' || trim($row['taux_de_disponnibilite_c']) == '#N/A') ? NULL : (100 * $row['taux_de_disponnibilite_c']),


            // 'stock_image' => $row['image_de_stock'],
            // 'nbr_produits_perimes' => $row['nbr_de_produits_perimes'],
            // 'nbr_proche_perimes' => $row['nbr_de_proche_perime'],
            // 'capacite' => $row['capacite'],
            // 'taux_occupation' => (100 * $row["taux_doccupation"]),
            // 'taux_peremption' => (100 * $row['taux_de_peremption']),
            // 'taux_proche_perime' => (100 * $row['taux_de_proche_perime']),
            // 'taux_rupture' => trim($row['taux_de_rupture']) == '-' ? NULL : (100 * $row['taux_de_rupture']),
            // 'taux_proche_penuerie' => trim($row['taux_de_proche_penuerie']) == '-' ? NULL : (100 * $row['taux_de_proche_penuerie']),
            // 'taux_disponibilite_a' => (100 * $row['taux_de_disponnibilite_a']),
            // 'taux_disponibilite_b' => (100 * $row['taux_de_disponnibilite_b']),
            // 'taux_disponibilite_c' => (100 * $row['taux_de_disponnibilite_c'])
        ]);
    }
}
