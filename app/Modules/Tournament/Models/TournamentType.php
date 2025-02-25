<?php

namespace App\Modules\Tournament\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Tournament\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TournamentType extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'tournament_types';
    protected $guarded = ['id'];


    public function tournaments(){
        return $this->hasMany(Tournament::class);
    }
    
    public static function relations($getOne = false){
        return $getOne 
            ? []
            : [];
            
    }
}
