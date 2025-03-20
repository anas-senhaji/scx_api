<?php

namespace App\Imports;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use App\Modules\Dci\Models\Dci;
use App\Modules\Dci\Models\DoseDci;
use App\Modules\Dci\Models\DoseDciStat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DcisImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $months = [
            'janvier' => 'January', 'fevrier' => 'February', 'mars' => 'March',
            'avril' => 'April', 'mai' => 'May', 'juin' => 'June',
            'juillet' => 'July', 'août' => 'August', 'septembre' => 'September',
            'octobre' => 'October', 'novembre' => 'November', 'décembre' => 'December'
        ];

        $dateString = strtolower($row['date']); // Convert to lowercase to match keys
        $dateString = str_replace(array_keys($months), array_values($months), $dateString);
        $dci = Dci::firstOrCreate(['name' =>trim($row['dci'])]);
        $dosDesi = DoseDci::create([
            'name'  => $row['dci_dose'],
            'dcis_id' => $dci->id,
        ]);
        return new DoseDciStat([
            'date' => Carbon::createFromFormat('F Y', ucfirst($dateString))->format('Y-m-d'),
            'consommation'  => is_numeric($row['consommation']) ? $row['consommation'] : null,
            'prevision' => is_numeric($row['prevision']) ? $row['prevision'] : null,
            'ecart' => is_numeric($row['ecart']) ? $row['ecart'] : null,
            'dose_dcis_id' => $dosDesi->id,
            'fullname' =>$row['concat_1']
        ]);
    }
}
