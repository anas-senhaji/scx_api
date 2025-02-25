<?php

namespace App\Modules\Statistic\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\UMMC\Models\UMMC;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UmmcStatistic extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'ummc_statistics';
    protected $guarded = ['id'];

    public function ummcs(){
        return $this->belongsTo(UMMC::class);
    }
}
