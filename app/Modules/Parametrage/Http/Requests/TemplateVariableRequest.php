<?php

namespace App\Modules\Parametrage\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class TemplateVariableRequest extends BaseFormRequest
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
            'template_id' => 'required',
            'equivalents' => 'required|array',
        ];
    }

    public function update()
    {
        return [
            'template_id' => 'required',
            'equivalents' => 'required|array',
        ];
    }
}
