<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Modules\UMMC\Models\UMMC;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Modules\Statistic\Models\UmmcStatistic;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UmmcStatisticImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $ummc = UMMC::where('name',$row['ummc'])->first();
        return new UmmcStatistic([
            'date'  => Carbon::instance(Date::excelToDateTimeObject($row['date']))->format('Y-m-d'),
            'ummc_id' => $ummc->id ?? null,
            'nbr_consultation' => $row['nombre_de_consultation'],
            'nbr_medicament_prescrit' => $row['nombre_de_medicament_prescrits'],
            'nbr_prescription' => $row['nombre_de_prescription'],
            'taux_prescription' => (100 * $row['taux_de_prescription']),
            'nbr_dispentation' => $row["nombre_de_dispensation"],
            'taux_adoption' => (100 * (float)$row["taux_dadoption"]),
            'nbr_medicament_dispense' => $row['nombre_de_medicaments_dispenses'],
            'taux_couverture' => (100 * $row['taux_de_couverture']),
            'moyen_medicament_par_prescription' => $row['moyen_medicament_par_prescription'],
            'capacite' => $row['capacite'],
            'stock' => trim($row['stock']) == '#N/A' ? NULL : $row['stock'],
            'taux_occupation' => trim($row['taux_doccupation']) == '#N/A' ? NULL : (100 * $row['taux_doccupation']),
            'taux_peremption' => trim($row['taux_de_peremption']) == '#N/A' ? NULL : (100 * $row['taux_de_peremption']),
            'taux_proche_perime' => trim($row['taux_de_proche_perime']) == '#N/A' ? NULL : (100 * $row['taux_de_proche_perime']),
            'taux_rupture' => trim($row['taux_de_rupture']) == '#N/A' ? NULL : 100 * $row['taux_de_rupture'],
            'taux_proche_penuerie' => trim($row['taux_de_proche_penuerie']) == '#N/A' ? NULL : (100 * $row['taux_de_proche_penuerie']),
            'taux_disponibilite_a' => trim($row['taux_de_disponnibilite_a']) == '#N/A' ? NULL : (100 * $row['taux_de_disponnibilite_a']),
            'taux_disponibilite_b' => trim($row['taux_de_disponnibilite_b']) == '#N/A' ? NULL : (100 * $row['taux_de_disponnibilite_b']),
            'taux_disponibilite_c' => trim($row['taux_de_disponnibilite_c']) == '#N/A' ? NULL : (100 * $row['taux_de_disponnibilite_c'])
        ]);
    }
}
