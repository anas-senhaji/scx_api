<?php

namespace App\Modules\Statistic\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\ULC\Models\ULC;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UlcStatistic extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'ulc_statistics';
    protected $guarded = ['id'];

    public function ulcs(){
        return $this->belongsTo(ULC::class);
    }
}
