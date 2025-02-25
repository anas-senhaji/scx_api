<?php

namespace App\Imports;


use App\Modules\ULC\Models\ULC;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UlcsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        return new ULC([
            'name'  => $row['ulc'],
            'position_x' => $row['x'],
            'position_y' => $row['y'],
        ]);
    }
    
}
