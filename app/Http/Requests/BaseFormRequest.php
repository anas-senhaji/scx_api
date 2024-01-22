<?php

namespace App\Http\Requests;

use Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BaseFormRequest extends FormRequest
{
    public $validator = null;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()){
            case 'POST' :
                $rules = $this->store();
                break;
            case 'PUT'  :
                $rules = $this->update();
                break;
            case 'DELETE' :
                $rules = $this->destroy();
                break;
            default:
                $rules = $this->view();
        }
        return $rules;
    }

    /**
     * Get the validation rules that apply to the get request.
     *
     * @return array
     */
    public function view()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation rules that apply to the post request.
     *
     * @return array
     */
    public function store()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation rules that apply to the put/patch request.
     *
     * @return array
     */
    public function update()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation rules that apply to the delete request.
     *
     * @return array
     */
    public function destroy()
    {
        return [
            //
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
