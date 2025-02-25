<?php

namespace App\Imports;


use App\Modules\ULC\Models\ULC;
use App\Modules\UMMC\Models\UMMC;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UmmcsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $ulc = ULC::where('name',$row['ulc'])->first();
        return new UMMC([
            'name'  => $row['warehouse_name'],
            'ulc_id'  => $ulc->id,
            'position_x' => $row['x'],
            'position_y' => $row['y'],
        ]);
    }
}
