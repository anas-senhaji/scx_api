<?php

namespace App\Modules\Parametrage\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Collaborateur\Models\Collaborateur;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkflowValidationHistorique extends Model
{
    use HasFactory, HasUuid, HasHorodatage;
    protected $with = ['collaborateur'];
    protected $hidden = ['validable_type', 'validable_id'];

    protected $table = 'workflow_historiques';
    protected $guarded = ['id'];

    public function validable(){
        return $this->morphTo();
    }
    public function collaborateur(){
        return $this->belongsTo(Collaborateur::class);
    }
}   
