<?php

namespace App\Modules\Salaire\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salaire extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'salaires';

    public function collaborateur(){
        return $this->belongsTo(Collaborateur::class);
    }
}
