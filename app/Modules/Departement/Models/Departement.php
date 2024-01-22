<?php

namespace App\Modules\Departement\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Collaborateur\Models\Collaborateur;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departement extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'departements';
    protected $guarded = ['id'];

    public function collaborateurs(){
        return $this->hasMany(Collaborateur::class);
    }

    public static function relations($getOne = false){
        return $getOne 
            ? [
                'collaborateurs',
            ]
            : [
                'collaborateurs',
            ];
            
    }
}
