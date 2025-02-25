<?php

namespace App\Imports;


use App\Imports\UlcStatisticImport;
use App\Imports\UmmcStatisticImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UlcUmmcStatisticImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            1 => new UlcStatisticImport(), // Feuille 2
            0 => new UmmcStatisticImport() // Feuille 1
        ];
    }
}
