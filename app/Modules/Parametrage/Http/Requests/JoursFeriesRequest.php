<?php

namespace App\Modules\Parametrage\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class JoursFeriesRequest extends BaseFormRequest
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
            'nom' => 'required|string',
            'dates' => 'required|array',
            'fixe' => 'nullable|boolean',
        ];
    }

    public function update()
    {
        return [
            'nom' => 'nullable|string',
            'dates' => 'nullable|array',
            'fixe' => 'nullable|boolean',
        ];
    }
}
