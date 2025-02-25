<?php

namespace App\Modules\ULC\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\UMMC\Models\UMMC;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Statistic\Models\UlcStatistic;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ULC extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'ulcs';
    protected $guarded = ['id'];

    public function ummcs(){
        return $this->hasMany(UMMC::class);
    }

    public function statistics(){
        return $this->hasMany(UlcStatistic::class);
    }
}
