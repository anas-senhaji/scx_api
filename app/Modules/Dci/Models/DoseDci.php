<?php

namespace App\Modules\Dci\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\Dci\Models\Dci;
use App\Modules\Dci\Models\DoseDciStat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoseDci extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'dose_dcis';
    protected $guarded = ['id'];

    public function dci(){
        return $this->belongsTo(Dci::class);
    }

    public function dosedecistats(){
        return $this->hasMany(DoseDciStat::class, "dose_dcis_id");
    }
}
