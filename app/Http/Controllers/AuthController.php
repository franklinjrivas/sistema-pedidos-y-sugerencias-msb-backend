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
        try {
            $username = $request->username;
            $password = $request->password;

            $login = $this->authService->login($username, $password);

            if (!isset($login) || empty($login)) throw new \Exception('El servicio de Autenticación está presentando problemas...');

            if (!$login['success']) throw new \Exception($login['mensaje']);

            return response()->json($login);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            $JWT_token = $request->JWT_token;

            $logout = $this->authService->logout($JWT_token);

            if (!$logout['success']) throw new \Exception($logout['mensaje']);

            return response()->json($logout);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Sesión cerrada'
            ]);
        }
    }

    public function check_intranet_url(Request $request)
    {
        try {
            $JWT_token = $request->JWT_token;
            $intranetURL = $request->intranetURL;

            $check = $this->authService->check_intranet_url($JWT_token, $intranetURL);

            if (!$check['success']) throw new \Exception($check['mensaje']);

            return response()->json($check);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Sesión cerrada'
            ]);
        }
    }
}
