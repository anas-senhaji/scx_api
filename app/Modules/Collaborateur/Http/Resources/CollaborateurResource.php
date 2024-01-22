<?php

namespace App\Modules\Collaborateur\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Conge\Http\Resources\CongeCollection;
use App\Modules\Groupe\Http\Resources\GroupeResource;
use App\Modules\Prime\Http\Resources\PrimeCollection;
use App\Modules\Contrat\Http\Resources\ContratResource;
use App\Modules\Groupe\Http\Resources\GroupeCollection;
use App\Modules\Salaire\Http\Resources\SalaireResource;
use App\Modules\Conge\Http\Resources\SoldeCongeResource;
use App\Modules\Salaire\Http\Resources\SalaireCollection;
use App\Modules\Departement\Http\Resources\DepartementResource;

class CollaborateurResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'photo' => $this->photo,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'adresse_personnelle' => $this->adresse_personnelle,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'identification_nationale' => $this->identification_nationale,
            'numero_securite_sociale' => $this->numero_securite_sociale,
            'rib' => $this->rib,
            'date_naissance' => $this->date_naissance,
            'situation' => $this->situation,
            'nombre_enfants' => $this->nombre_enfants,
            'nationalite' => $this->nationalite,
            'niveau_etudes' => $this->niveau_etudes,
            'diplomes' => $this->diplomes,
            'experiences_antierieurs' => $this->experiences_antierieurs,
            'langues' => $this->langues,
            'competences' => $this->competences,
            'avantages' => $this->avantages,
            'statut' => $this->statut,
            'fonction' => $this->fonction,
            'nombre_jours_conge' => $this->nombre_jours_conge,
            'salaire_de_base' => $this->salaire_de_base,
            'matricule' => $this->matricule,
            'commentaire' => $this->commentaire,
            'role' => $this->user->role,
            'groupe' => new GroupeResource($this->whenLoaded('groupe')),
            'departement' => new DepartementResource($this->whenLoaded('departement')),
            'superviseur' => new CollaborateurResource($this->whenLoaded('superviseur')),
            'subordonnes' => new CollaborateurCollection($this->whenLoaded('subordonnes')),
            'contrat' => new ContratResource($this->whenLoaded('contrat')),
            'salaires' => new SalaireCollection($this->whenLoaded('salaires')),
            'salaireActuel' => new SalaireResource($this->whenLoaded('salaireActuel')),
            'primes' => new PrimeCollection($this->whenLoaded('primes')),
            'conges' => new CongeCollection($this->whenLoaded('conges')),
            'soldeCoges' => new SoldeCongeResource($this->whenLoaded('soldeCoges')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
