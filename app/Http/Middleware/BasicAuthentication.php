<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthentication
{
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

        // Extraer las credenciales del encabezado de autorización
        [$type, $credentials] = explode(' ', $authorizationHeader);

        if (strcasecmp($type, 'basic') !== 0) {
            return response()->json([
                'mensaje' => 'Tipo de autenticación no válido'
            ], 401);
        }

        // Decodificar las credenciales
        $decodedCredentials = base64_decode($credentials);
        if ($decodedCredentials === false) {
            return response()->json([
                'mensaje' => 'Error al decodificar las credenciales',
            ], 401);
        }

        // Dividir las credenciales en usuario y contraseña
        [$user, $pass] = explode(':', $decodedCredentials, 2);

        // Obtener el array de credenciales de la variable de entorno
        $authBasic = json_decode(file_get_contents(database_path('data_seeds/credenciales_for_auth_basic_api.json')), true);

        // Verificar si $authBasic tiene la estructura esperada
        if (!isset($authBasic['CREDENTIALS']) || !is_array($authBasic['CREDENTIALS'])) {
            return response()->json([
                'mensaje' => 'La estructura de credenciales no es la esperada'
            ], 401);
        }

        // Buscar las credenciales que coincidan con $user y $pass
        $credentialsFound = collect($authBasic['CREDENTIALS'])->first(function ($credential) use ($user, $pass) {
            return $credential['user'] === $user && $credential['pwd'] === $pass;
        });

        // Verificar si se encontraron las credenciales
        if (!$credentialsFound) {
            return response()->json([
                'mensaje' => 'Basic Auth Invalid'
            ], 401);
        }

        return $next($request);
    }
}
