<?php

namespace App\Modules\Parametrage\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class TemplateRequest extends BaseFormRequest
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
            'file' => 'required',
            'type' => 'required|string',
        ];
    }

    public function update()
    {
        return [
            'nom' => 'required|string',
            'file' => 'required',
            'type' => 'required|string',
        ];
    }
}
