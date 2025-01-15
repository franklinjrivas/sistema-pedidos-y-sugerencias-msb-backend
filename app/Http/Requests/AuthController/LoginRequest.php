<?php

namespace App\Http\Requests\AuthController;

use App\Http\Requests\BaseRequest;

use App\Services\RecaptchaService;

class LoginRequest extends BaseRequest
{
    private $recaptchaService;

    public function __construct(RecaptchaService $recaptchaService)
    {
        $this->recaptchaService = $recaptchaService;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $token = $this->input('captcha');
        return $this->recaptchaService->validateRecaptchaV2($token);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'bail|required|max:50',
            'password' => 'bail|required|max:50',
            'captcha' => 'bail|required',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'El Username es requerido',
            'username.max' => 'El Username no debe execeder los 50 caracteres',
            'password.required' => 'La Contraseña es requerida',
            'password.max' => 'La contraseña no debe exceder los 50 caracteres',
            'captcha.required' => 'Demuestra que no eres un Robot haciendo click en la casilla de verificación',
        ];
    }
}
