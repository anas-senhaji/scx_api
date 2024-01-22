<?php

namespace App\Modules\Departement\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class DepartementRequest extends BaseFormRequest
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
            'description' => 'nullable|string',
        ];
    }

    public function update()
    {
        return [
            'nom' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}
