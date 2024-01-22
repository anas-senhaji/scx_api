<?php

namespace App\Modules\Collaborateur\Models;

use App\Models\User;
use App\Traits\HasUuid;
use App\Traits\Resourceable;
use App\Traits\HasHorodatage;
use App\Modules\Conge\Models\Conge;
use App\Modules\Prime\Models\Prime;
use App\Modules\Groupe\Models\Groupe;
use App\Modules\Contrat\Models\Contrat;
use App\Modules\Salaire\Models\Salaire;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Conge\Models\SoldeConge;
use App\Modules\Departement\Models\Departement;
use App\Modules\Collaborateur\Models\Collaborateur;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Collaborateur\Http\Resources\CollaborateurResource;

class Collaborateur extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'collaborateurs';
    protected $guarded = ['id'];
    protected $casts = [
        'diplomes' => 'array',
        'experiences_antierieurs' => 'array',
        'langues' => 'array',
        'competences' => 'array',
        'avantages' => 'array',
    ];

    public function user(){
        return $this->hasOne(User::class)->with('role');
    }

    public function groupe(){
        return $this->belongsTo(Groupe::class);
    }

    public function departement(){
        return $this->belongsTo(Departement::class);
    }

    public function contrat(){
        return $this->hasOne(Contrat::class);
    }

    public function salaires(){
        return $this->hasMany(Salaire::class);
    }

    public function salaireActuel(){
        return $this->hasOne(Salaire::class)->latest();
    }

    public function primes(){
        return $this->hasMany(Prime::class);
    }

    public function superviseur(){
        return $this->belongsTo(Collaborateur::class, 'superviseur_id')->with('superviseur');
    }

    public function subordonnes(){
        return $this->hasMany(Collaborateur::class, 'superviseur_id')->with('subordonnes');
    }

    public function conges(){
        return $this->hasMany(Conge::class);
    }

    public function soldeCoges(){
        return $this->hasMany(SoldeConge::class);
    }

    
    public static function relations($getOne = false){
        return $getOne 
            ? [
                'user',
                'groupe',
                'departement',
                'contrat',
                'salaires',
                'salaireActuel',
                'primes',
                'superviseur',
                'subordonnes',
                'conges',
                'soldeCoges',
            ]
            : [
                'groupe',
                'departement',
                'superviseur',
                'subordonnes',
                'contrat',
            ];
            
    }
}
