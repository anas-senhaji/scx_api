<?php

namespace App\Modules\Parametrage\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\Conge\Models\Conge;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeConge extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'type_conges';
    protected $guarded = ['id'];

    public function conges(){
        return $this->hasMany(Conge::class);
    }
}
