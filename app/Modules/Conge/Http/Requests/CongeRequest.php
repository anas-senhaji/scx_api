<?php

namespace App\Modules\Conge\Http\Requests;

use App\Enums\eStatutConge;
use App\Http\Requests\BaseFormRequest;

class CongeRequest extends BaseFormRequest
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
    public function store()
    {
        return [
            'date_debut' => 'required|date:"Y-m-d H:i:s"',
            'date_fin' => 'required|date:"Y-m-d H:i:s"',
            'justification' => 'nullable|file',
            'note' => 'nullable|string',
            'nombre_jours' => 'required|numeric',
            'collaborateur_id' => 'nullable|string',
            'type_conge_id' => 'required|string',
        ];
    }

    public function update()
    {
        return [
            'date_debut' => 'required|date:"Y-m-d H:i:s"',
            'date_fin' => 'required|date:"Y-m-d H:i:s"',
            'date_fin' => 'required|date',
            'justification' => 'nullable|file',
            'note' => 'nullable|string',
            'nombre_jours' => 'required|numeric',
            'collaborateur_id' => 'required|string',
            'type_conge_id' => 'required|string',
        ];
    }
}
