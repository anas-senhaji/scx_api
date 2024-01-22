<?php

namespace App\Modules\Collaborateur\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Collaborateur\Models\Collaborateur;

class CollaborateurRequest extends BaseFormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function store(){
        return [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'photo' => 'required|image',
            'adresse_personnelle' => 'required|string',
            'email' => 'required|email|unique:collaborateurs,email',
            'telephone' => 'required|string', 
            'identification_nationale' => 'required|string',
            'numero_securite_sociale' => 'required|string',
            'rib' => 'required|string',
            'date_naissance' => 'required|date',
            'situation' => 'required|string',
            'nombre_enfants' => 'required|numeric',
            'nationalite' => 'required|string',
            'niveau_etudes' => 'nullable|string',
            'diplomes' => 'nullable|array',
            'experiences_antierieurs' => 'nullable|array',
            'langues' => 'nullable|array',
            'competences' => 'nullable|array',
            'avantages' => 'nullable|array',
            'primes' => 'nullable|array',
            'salaire_de_base' => 'required|numeric',
            'nombre_jours_conge' => 'required|numeric',
            'status' => 'required|boolean',
            'fonction' => 'required|string',
            'matricule' => 'required|string',
            'commentaire' => 'nullable|string',
            'groupe_id' => 'required|numeric',
            'departement_id' => 'required|numeric',
        ];
    }

     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function update(){
        return [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            // 'photo' => 'required|image',
            'adresse_personnelle' => 'required|string',
            // 'email' => 'required|email|unique:collaborateurs,email,'.$collaborateur->id,
            'email' => 'required|email',
            'telephone' => 'required|string', 
            'identification_nationale' => 'required|string',
            'numero_securite_sociale' => 'required|string',
            'rib' => 'required|string',
            'date_naissance' => 'required|date',
            'situation' => 'required|string',
            'nombre_enfants' => 'required|numeric',
            'nationalite' => 'required|string',
            'niveau_etudes' => 'nullable|string',
            'diplomes' => 'nullable|array',
            'experiences_antierieurs' => 'nullable|array',
            'langues' => 'nullable|array',
            'competences' => 'nullable|array',
            'avantages' => 'nullable|array',
            'primes' => 'nullable|array',
            'salaire_de_base' => 'required|numeric',
            'nombre_jours_conge' => 'required|numeric',
            'status' => 'required|boolean',
            'fonction' => 'required|string',
            'matricule' => 'required|string',
            'commentaire' => 'nullable|string',
            'groupe_id' => 'required|numeric',
            'departement_id' => 'required|numeric',
        ];
    }
    
}
