<?php

namespace App\Modules\Location\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Location\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'cities';
    protected $guarded = ['id'];

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
