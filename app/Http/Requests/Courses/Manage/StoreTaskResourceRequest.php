<?php

namespace App\Http\Requests\Courses\Manage;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskResourceRequest extends FormRequest
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
    public function rules()
    {
        return [
            'resources' => 'required|array',
            'resources.*' => 'required'
        ];
    }

    public function messages(){
        return [
            'resources.required' => "Todos los campos para registrar nuevos recursos son requeridos",
        ];
    }
}
