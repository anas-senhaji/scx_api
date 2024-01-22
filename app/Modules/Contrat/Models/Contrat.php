<?php

namespace App\Modules\Contrat\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Parametrage\Models\Template;
use App\Modules\Collaborateur\Models\Collaborateur;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contrat extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'contrats';

    public function collaborateur(){
        return $this->belongsTo(Collaborateur::class);
    }
}
