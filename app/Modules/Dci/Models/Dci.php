<?php

namespace App\Modules\Dci\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\Dci\Models\DoseDci;
use App\Modules\Dci\Models\DoseDciStat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dci extends Model
{
    use HasFactory, HasUuid;
    protected $table = 'dcis';
    protected $guarded = ['id'];
    // protected $with = ['dosedcis'];

    public function dosedcis(){
        return $this->hasMany(DoseDci::class, "dcis_id");
    }

    public function dosedecistats(){
        return $this->hasMany(DoseDciStat::class, "dci_id");
    }
}
