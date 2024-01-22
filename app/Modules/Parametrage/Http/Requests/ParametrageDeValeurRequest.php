<?php

namespace App\Modules\Parametrage\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseFormRequest;
use App\Enums\eTypeParametrageDeValeur;

class ParametrageDeValeurRequest extends BaseFormRequest
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
            'nom' => [Rule::in(eTypeParametrageDeValeur::getAll(eTypeParametrageDeValeur::class))],
            'minimum' => 'required|numeric',
            'maximum' => 'required|numeric',
        ];
    }

    public function update()
    {
        return [
            'nom' => [Rule::in(eTypeParametrageDeValeur::getAll(eTypeParametrageDeValeur::class))],
            'minimum' => 'nullable|numeric',
            'maximum' => 'nullable|numeric',
        ];
    }
}
