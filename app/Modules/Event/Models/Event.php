<?php

namespace App\Modules\Event\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Location\Models\Country;
use App\Modules\Organizer\Models\Organizer;
use App\Modules\Discipline\Models\Discipline;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'events';
    protected $guarded = ['id'];


    public function organizer(){
        return $this->belongsTo(Organizer::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function discipline(){
        return $this->belongsTo(Discipline::class);
    }

    public static function relations($getOne = false){
        return $getOne 
            ? [
                'organizer', 'discipline'
            ]
            : [
                'organizer', 'discipline'
            ];
            
    }
}
