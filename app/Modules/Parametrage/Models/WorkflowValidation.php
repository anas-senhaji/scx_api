<?php

namespace App\Modules\Parametrage\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkflowValidation extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'workflow_validations';
    protected $guarded = ['id'];
}
