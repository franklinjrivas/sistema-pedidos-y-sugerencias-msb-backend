<?php

namespace App\Http\Requests\HomeController;

use App\Http\Requests\BaseRequest;

class MenuRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_rol' => 'bail|required',
        ];
    }

    public function messages()
    {
        return [
            'id_rol.required' => 'El Rol es requerido',
        ];
    }
}
