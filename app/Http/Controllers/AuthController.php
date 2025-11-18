<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AuthController\LoginRequest;

use App\Services\AuthService;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $username = $request->username;
        $password = $request->password;

        $login = $this->authService->login($username, $password);

        if (!isset($login) || empty($login)) validationError('El servicio de Autenticación está presentando problemas...');

        if (!$login['success']) validationError($login['mensaje']);

        return response()->json($login);
    }

    public function logout(Request $request)
    {
        $JWT_token = $request->JWT_token;

        $logout = $this->authService->logout($JWT_token);

        if (!$logout['success']) validationError($logout['mensaje']);

        return response()->json($logout);
    }

    public function check_intranet_url(Request $request)
    {
        $JWT_token = $request->JWT_token;
        $intranetURL = $request->intranetURL;

        $check = $this->authService->check_intranet_url($JWT_token, $intranetURL);

        if (!$check['success']) validationError($check['mensaje']);

        return response()->json($check);
    }

    public function validate_jwt(Request $request)
    {
        $JWT_token = $request->JWT_token;

        $validate = $this->authService->validateJWT($JWT_token);

        if (!isset($validate) || empty($validate)) validationError('El servicio de Autenticación está presentando problemas...');

        if (!$validate['success']) validationError($validate['mensaje']);

        return response()->json($validate);
    }
}
