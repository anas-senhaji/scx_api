<?php

namespace App\Modules\Parametrage\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Parametrage\Models\TemplateVariable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'templates';
    protected $guarded = ['id'];

    public function variables(){
        return $this->hasMany(TemplateVariable::class);
    }
}
