<?php

namespace App\Modules\Conge\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Collaborateur\Models\Collaborateur;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SoldeConge extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'solde_conge';
    protected $guarded = ['id'];

    public function collaborateur(){
        return $this->belongsTo(Collaborateur::class);
    }
}
