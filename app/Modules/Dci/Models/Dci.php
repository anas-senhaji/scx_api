<?php

namespace App\Modules\Dci\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\Dci\Models\DoseDci;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dci extends Model
{
    use HasFactory, HasUuid, HasHorodatage;
    protected $table = 'dcis';
    protected $guarded = ['id'];

    public function dosedcis(){
        return $this->hasMany(DoseDci::class, "dcis_id");
    }
}
