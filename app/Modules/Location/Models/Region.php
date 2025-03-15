<?php

namespace App\Modules\Location\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\ULC\Models\ULC;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'regions';
    protected $guarded = ['id'];

    public function ulcs(){
        return $this->hasMany(ULC::class, "region_id");
    }


}
