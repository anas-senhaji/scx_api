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
        $dci = Dci::firstOrCreate(['name' =>trim($row['dci'])]);
        $dosDesi = DoseDci::create([
            'name'  => $row['dci_dose'],
            'dcis_id' => $dci->id,
        ]);
        return new DoseDciStat([
            'date' => '2025-02-01',
            'consommation'  => is_numeric($row['consommation']) ? $row['consommation'] : null,
            'prevision' => is_numeric($row['prevision']) ? $row['prevision'] : null,
            'ecart' => is_numeric($row['ecart']) ? $row['ecart'] : null,
            'dose_dcis_id' => $dosDesi->id,
            'fullname' =>$row['concat_1']
        ]);
    }
}
