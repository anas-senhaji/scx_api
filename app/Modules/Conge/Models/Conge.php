<?php

namespace App\Modules\Conge\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Parametrage\Models\TypeConge;
use App\Modules\Collaborateur\Models\Collaborateur;
use App\Modules\Parametrage\Models\WorkflowValidation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Parametrage\Models\WorkflowValidationHistorique;

class Conge extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'conges';
    protected $guarded = ['id'];
    protected $casts = [
        'workflow' => 'array'
    ];

    public function collaborateur(){
        return $this->belongsTo(Collaborateur::class);
    }
    public function typeConge(){
        return $this->belongsTo(TypeConge::class);
    }
    public function workflowValidationHistoriques(){
        return $this->morphMany(WorkflowValidationHistorique::class, 'validable');
    }

    public static function relations($getOne = false){
        return $getOne 
            ? [
                'workflowValidationHistoriques'
            ]
            : [
                'collaborateur',
                'typeConge', 
                'workflowValidationHistoriques'
            ];
            
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($conge) {
            // Retrieves a list of "workflow validations", filtered by type and active status, and with only specific columns selected.
            $workflowConge = WorkflowValidation::where(['type' => 'CONGE', 'active' => true])
                ->get(['role_id', 'user_id', 'est_superviseur', 'niveau'])
                // This maps the retrieved list of "workflow validations" to a new list with only the four specified columns.
                ->map(function ($workflow) {
                    return [
                        'role_id' => $workflow->role_id,
                        'user_id' => $workflow->user_id,
                        'est_superviseur' => $workflow->est_superviseur,
                        'niveau' => $workflow->niveau,
                    ];
                })
                // This filters out any items in the list where the "est_superviseur" column is 1 and the authenticated user does not have a supervisor.
                ->reject(function ($workflow) {
                    return empty(Auth::user()->collaborateur->superviseur) && $workflow['est_superviseur'] == 1;
                })
                // This re-indexes the list so that it starts at index 0 and returns the resulting list as an array.
                ->values()
                ->toArray();
            // This assigns the resulting list of "workflow validations" to a property of the new "conge" object being created, and calculates the initial "niveau_valide" (valid level) by subtracting 1 from the "niveau" (level) of the first item in the list.
            $conge->workflow = $workflowConge;
            $conge->niveau_valide = (int) reset($workflowConge)['niveau'] - 1;
        });
    }
}
