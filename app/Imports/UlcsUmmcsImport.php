<?php

namespace App\Imports;

use App\Imports\UlcsImport;
use App\Imports\UmmcsImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UlcsUmmcsImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            1 => new UlcsImport(), // Feuille 2
            0 => new UmmcsImport() // Feuille 1
        ];
    }
}
