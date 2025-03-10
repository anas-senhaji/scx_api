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
            'nbr_consultation' => (trim($row['nombre_de_consultation']) == '#N/A' || trim($row['nombre_de_consultation']) == '' || trim($row['nombre_de_consultation']) == '#DIV/0!' || trim($row['nombre_de_consultation']) == 'infinity%' || trim($row['nombre_de_consultation']) == '-') ? NULL : $row['nombre_de_consultation'],
            'nbr_medicament_prescrit' => (trim($row['nombre_de_medicament_prescrits']) == '#N/A' || trim($row['nombre_de_medicament_prescrits']) == '' || trim($row['nombre_de_medicament_prescrits']) == '#DIV/0!' || trim($row['nombre_de_medicament_prescrits']) == 'infinity%' || trim($row['nombre_de_medicament_prescrits']) == '-') ? NULL : $row['nombre_de_medicament_prescrits'],
            'nbr_prescription' => (trim($row['nombre_de_prescription']) == '#N/A' || trim($row['nombre_de_prescription']) == '' || trim($row['nombre_de_prescription']) == '#DIV/0!' || trim($row['nombre_de_prescription']) == 'infinity%' || trim($row['nombre_de_prescription']) == '-') ? NULL : $row['nombre_de_prescription'],
            'taux_prescription' => (empty($row['taux_de_prescription']) || trim($row['taux_de_prescription']) == '#DIV/0!' || trim($row['taux_de_prescription']) == 'infinity%' || trim($row['taux_de_prescription']) == '-' || trim($row['taux_de_prescription']) == '#N/A') ? NULL : (100 * $row['taux_de_prescription']),
            'nbr_dispentation' => (trim($row['nombre_de_dispensation']) == '#N/A' || trim($row['nombre_de_dispensation']) == '' || trim($row['nombre_de_dispensation']) == '#DIV/0!' || trim($row['nombre_de_dispensation']) == 'infinity%' || trim($row['nombre_de_dispensation']) == '-') ? NULL : $row["nombre_de_dispensation"],
            'taux_service_ordonnance' => (empty($row["taux_de_service_ordonnance"]) || trim($row["taux_de_service_ordonnance"]) == '#DIV/0!' || trim($row["taux_de_service_ordonnance"]) == 'infinity%' || trim($row["taux_de_service_ordonnance"]) == '-' || trim($row["taux_de_service_ordonnance"]) == '#N/A') ? NULL : (100 * (float)$row["taux_de_service_ordonnance"]),
            'nbr_medicament_dispense' => (trim($row['nombre_de_medicaments_dispenses']) == '#N/A' || trim($row['nombre_de_medicaments_dispenses']) == '' || trim($row['nombre_de_medicaments_dispenses']) == '#DIV/0!' || trim($row['nombre_de_medicaments_dispenses']) == 'infinity%' || trim($row['nombre_de_medicaments_dispenses']) == '-') ? NULL : $row['nombre_de_medicaments_dispenses'],
            'taux_service_medicament' => (empty($row['taux_de_service_medicament']) || trim($row['taux_de_service_medicament']) == '#DIV/0!' || trim($row['taux_de_service_medicament']) == 'infinity%' || trim($row['taux_de_service_medicament']) == '-' || trim($row['taux_de_service_medicament']) == '#N/A') ? NULL : (100 * $row['taux_de_service_medicament']),
            'moyen_medicament_par_prescription' => (trim($row['moyen_medicament_par_prescription']) == '#N/A' || trim($row['moyen_medicament_par_prescription']) == '' || trim($row['moyen_medicament_par_prescription']) == '#DIV/0!' || trim($row['moyen_medicament_par_prescription']) == 'infinity%' || trim($row['moyen_medicament_par_prescription']) == '-') ? NULL : $row['moyen_medicament_par_prescription'],
            'capacite' => (trim($row['capacite']) == '#N/A' || trim($row['capacite']) == '' || trim($row['capacite']) == '#DIV/0!' || trim($row['capacite']) == 'infinity%' || trim($row['capacite']) == '-') ? NULL : $row['capacite'],
            'stock' => (trim($row['stock']) == '#N/A' || trim($row['stock']) == '' || trim($row['stock']) == '#DIV/0!' || trim($row['stock']) == 'infinity%' || trim($row['stock']) == '-') ? NULL : $row['stock'],
            'taux_occupation' => (empty($row['taux_doccupation']) || trim($row['taux_doccupation']) == '#DIV/0!' || trim($row['taux_doccupation']) == 'infinity%' || trim($row['taux_doccupation']) == '-' || trim($row['taux_doccupation']) == '#N/A') ? NULL : (100 * $row['taux_doccupation']),
            'taux_peremption' => (empty($row['taux_de_peremption']) || trim($row['taux_de_peremption']) == '#DIV/0!' || trim($row['taux_de_peremption']) == 'infinity%' || trim($row['taux_de_peremption']) == '-' || trim($row['taux_de_peremption']) == '#N/A') ? NULL : (100 * $row['taux_de_peremption']),
            'taux_proche_perime' => (empty($row['taux_de_proche_perime']) || trim($row['taux_de_proche_perime']) == '#DIV/0!' || trim($row['taux_de_proche_perime']) == 'infinity%' || trim($row['taux_de_proche_perime']) == '-' || trim($row['taux_de_proche_perime']) == '#N/A') ? NULL : (100 * $row['taux_de_proche_perime']),
            'taux_rupture' => (empty($row['taux_de_rupture']) || trim($row['taux_de_rupture']) == '#DIV/0!' || trim($row['taux_de_rupture']) == 'infinity%' || trim($row['taux_de_rupture']) == '-' || trim($row['taux_de_rupture']) == '#N/A') ? NULL : 100 * $row['taux_de_rupture'],
            'taux_proche_penuerie' => (empty($row['taux_de_proche_penuerie']) || trim($row['taux_de_proche_penuerie']) == '#DIV/0!' || trim($row['taux_de_proche_penuerie']) == 'infinity%' || trim($row['taux_de_proche_penuerie']) == '-' || trim($row['taux_de_proche_penuerie']) == '#N/A') ? NULL : (100 * $row['taux_de_proche_penuerie']),
            'taux_disponibilite_a' => (empty($row['taux_de_disponnibilite_a']) || trim($row['taux_de_disponnibilite_a']) == '#DIV/0!' || trim($row['taux_de_disponnibilite_a']) == 'infinity%' || trim($row['taux_de_disponnibilite_a']) == '-' || trim($row['taux_de_disponnibilite_a']) == '#N/A') ? NULL : (100 * $row['taux_de_disponnibilite_a']),
            'taux_disponibilite_b' => (empty($row['taux_de_disponnibilite_b']) || trim($row['taux_de_disponnibilite_b']) == '#DIV/0!' || trim($row['taux_de_disponnibilite_b']) == 'infinity%' || trim($row['taux_de_disponnibilite_b']) == '-' || trim($row['taux_de_disponnibilite_b']) == '#N/A') ? NULL : (100 * $row['taux_de_disponnibilite_b']),
            'taux_disponibilite_c' => (empty($row['taux_de_disponnibilite_c']) || trim($row['taux_de_disponnibilite_c']) == '#DIV/0!' || trim($row['taux_de_disponnibilite_c']) == 'infinity%' || trim($row['taux_de_disponnibilite_c']) == '-' || trim($row['taux_de_disponnibilite_c']) == '#N/A') ? NULL : (100 * $row['taux_de_disponnibilite_c']),


            // 'nbr_consultation' => $row['nombre_de_consultation'],
            // 'nbr_medicament_prescrit' => $row['nombre_de_medicament_prescrits'],
            // 'nbr_prescription' => $row['nombre_de_prescription'],
            // 'taux_prescription' => (100 * $row['taux_de_prescription']),
            // 'nbr_dispentation' => $row["nombre_de_dispensation"],
            // 'taux_service_ordonnance' => (100 * (float)$row["taux_de_service_ordonnance"]),
            // 'nbr_medicament_dispense' => $row['nombre_de_medicaments_dispenses'],
            // 'taux_service_medicament' => (100 * $row['taux_de_service_medicament']),
            // 'moyen_medicament_par_prescription' => $row['moyen_medicament_par_prescription'],
            // 'capacite' => $row['capacite'],
            // 'stock' => trim($row['stock']) == '#N/A' ? NULL : $row['stock'],
            // 'taux_occupation' => trim($row['taux_doccupation']) == '#N/A' ? NULL : (100 * $row['taux_doccupation']),
            // 'taux_peremption' => trim($row['taux_de_peremption']) == '#N/A' ? NULL : (100 * $row['taux_de_peremption']),
            // 'taux_proche_perime' => trim($row['taux_de_proche_perime']) == '#N/A' ? NULL : (100 * $row['taux_de_proche_perime']),
            // 'taux_rupture' => trim($row['taux_de_rupture']) == '#N/A' ? NULL : 100 * $row['taux_de_rupture'],
            // 'taux_proche_penuerie' => trim($row['taux_de_proche_penuerie']) == '#N/A' ? NULL : (100 * $row['taux_de_proche_penuerie']),
            // 'taux_disponibilite_a' => trim($row['taux_de_disponnibilite_a']) == '#N/A' ? NULL : (100 * $row['taux_de_disponnibilite_a']),
            // 'taux_disponibilite_b' => trim($row['taux_de_disponnibilite_b']) == '#N/A' ? NULL : (100 * $row['taux_de_disponnibilite_b']),
            // 'taux_disponibilite_c' => trim($row['taux_de_disponnibilite_c']) == '#N/A' ? NULL : (100 * $row['taux_de_disponnibilite_c'])
        ]);
    }
}
