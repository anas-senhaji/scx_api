<?php

namespace App\Modules\UMMC\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\ULC\Models\ULC;
use App\Modules\Dci\Models\DoseDciStat;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Statistic\Models\UmmcStatistic;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UMMC extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'ummcs';
    protected $guarded = ['id'];

    public function ulc(){
        return $this->belongsTo(ULC::class);
    }

    public function statistics(){
        return $this->hasMany(UmmcStatistic::class, "ummc_id");
    }

    public function dosedecistats(){
        return $this->hasMany(DoseDciStat::class, "ummc_id");
    }

    public static function relations($getOne = false){
        return $getOne 
            ? ['ulc', 'statistics']
            : ['ulc', 'statistics'];
            
    }
}
