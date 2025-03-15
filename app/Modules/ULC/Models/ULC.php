<?php

namespace App\Modules\ULC\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\UMMC\Models\UMMC;
use App\Modules\Location\Models\Region;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Statistic\Models\UlcStatistic;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ULC extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'ulcs';
    protected $guarded = ['id'];

    public function ummcs(){
        return $this->hasMany(UMMC::class, "ulc_id");
    }

    public function statistics(){
        return $this->hasMany(UlcStatistic::class, "ulc_id");
    }

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public static function relations($getOne = false){
        return $getOne 
            ? ['ummcs', 'statistics']
            : ['ummcs', 'statistics'];
            
    }
}
