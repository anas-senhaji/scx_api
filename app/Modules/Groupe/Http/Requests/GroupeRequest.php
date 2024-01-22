<?php

namespace App\Modules\Groupe\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class GroupeRequest extends BaseFormRequest
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
            'logo' => 'nullable|image',
            'description' => 'nullable|string',
        ];
    }

    public function update()
    {
        return [
            'nom' => 'nullable|string',
            'logo' => 'nullable|image',
            'description' => 'nullable|string',
        ];
    }
}
