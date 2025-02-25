<?php

namespace App\Modules\Discipline\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\Event\Models\Event;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Tournament\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discipline extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'disciplines';
    protected $guarded = ['id'];


    public function events(){
        return $this->hasMany(Event::class);
    }

    public function tournaments(){
        return $this->hasMany(Tournament::class);
    }

    public static function relations($getOne = false){
        return $getOne 
            ? []
            : [];
            
    }
}
