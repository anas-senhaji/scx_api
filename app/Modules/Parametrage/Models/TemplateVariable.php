<?php

namespace App\Modules\Parametrage\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Parametrage\Models\Template;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemplateVariable extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'template_variables';
    protected $guarded = ['id'];

    public function template(){
        return $this->belongsTo(Template::class);
    }
}
