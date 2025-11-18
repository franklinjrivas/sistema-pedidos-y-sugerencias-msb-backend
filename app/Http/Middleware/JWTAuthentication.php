<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Services\AuthService;

class JWTAuthentication
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = $request->header('Authorization');

        if (!$authorizationHeader) {
            return response()->json([
                'mensaje' => 'No Autorizado'
            ], 401);
        }

        [$type, $token] = explode(' ', $authorizationHeader);

        if (strcasecmp($type, 'bearer') !== 0) {
            return response()->json([
                'mensaje' => 'Tipo de autenticación no válido'
            ], 401);
        }

        if (!$token) {
            return response()->json([
                'mensaje' => 'Token no válido'
            ], 401);
        }

        $validate = $this->authService->validateJWT($token);

        if (!isset($validate) || empty($validate)) throw new \Exception('Token incorrecto');

        if (!$validate['success']) throw new \Exception($validate['mensaje']);

        $request->merge([
            'JWT_token' => $token,
            'JWT_username' => $validate['data']['username'],
            'JWT_session_id' => $validate['data']['session_id'],
        ]);

        return $next($request);
    }
}
