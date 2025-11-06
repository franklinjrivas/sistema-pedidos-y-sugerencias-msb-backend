<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use App\Services\AuthService;

if (!function_exists('log_info')) {
    function log_info($message)
    {
        Log::info($message);
    }
}

if (!function_exists('datos_for_aduditoria')) {
    function datos_for_aduditoria(Request $request)
    {
        $authService = App::make(AuthService::class);
        $auth = $authService->validateJWT($request->JWT_token);
        $username = 'system';

        if (!$auth || !$auth['success'] || !$auth['data']) {
            log_info('helpers -> datos_for_aduditoria -> $auth:');
            log_info($auth);
        } else {
            $username = $auth['data']['username'] ?? 'system';
        }

        return [
            'ip' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'username' => $username
        ];
    }
}
