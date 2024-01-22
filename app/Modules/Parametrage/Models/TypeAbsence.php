<?php

namespace App\Modules\Parametrage\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeAbsence extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'type_absences';
    protected $guarded = ['id'];
}
