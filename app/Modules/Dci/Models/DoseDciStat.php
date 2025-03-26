<?php

namespace App\Modules\Dci\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\Dci\Models\Dci;
use App\Modules\Dci\Models\DoseDci;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoseDciStat extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'dose_dcis_stats';
    protected $guarded = ['id'];

    public function dosedci(){
        return $this->belongsTo(DoseDci::class);
    }

    public function dci(){
        return $this->belongsTo(Dci::class);
    }

    public function ummc(){
        return $this->belongsTo(UMMC::class);
    }

    public function scopeByStartDate($query, $start_date = null)
    {
        if($start_date){
            return $query->where('date','>=', $start_date);
        }
        return $query;
    }

    public function scopeByEndDate($query, $end_date = null)
    {
        if($end_date){
            return $query->where('date','<=',$end_date);
        }
        return $query;
    }

    public function scopeByDci($query, $dci_id = null)
    {
        if($dci_id){
            return $query->where('dci_id', $dci_id);
        }
        return $query;
    }

    public function scopeByDoseDci($query, $dose_dcis_id = null)
    {
        if($dose_dcis_id){
            return $query->where('dose_dcis_id', $dose_dcis_id);
        }
        return $query;
    }

    public function scopeByUmmc($query, $ummc_id = null)
    {
        if($ummc_id){
            return $query->where('ummc_id', $ummc_id);
        }
        return $query;
    }
}
