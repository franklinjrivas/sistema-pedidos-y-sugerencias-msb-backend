<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Exceptions\BusinessLogicException;
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
if (!function_exists('validationError')) {
    function validationError(string $msg): never
    {
        throw new BusinessLogicException($msg);
    }
}
if (!function_exists('log_info')) {
	function log_info($message, array $context = []): void
	{
		if ($message instanceof \stdClass) {
			$message = (array) $message;
		}
		Log::info($message, $context);
	}
}
if (!function_exists('getPayload')) {
    function getPayload(): ?array
    {
        $payload = request()->all();

        if (isset($payload['password'])) {
            $payload['password'] = '********';
        }

        unset(
            $payload['JWT_data'],
            $payload['JWT_token'],
            $payload['JWT_username'],
            $payload['JWT_session_id'],
        );

        return empty($payload) ? null : $payload;
    }
}
if (!function_exists('getAudit')) {
    function getAudit(): array
    {
        return [
            'ip' => request()->ip(),
            'hostname' => getClientHostname(),
            'user_agent' => getClientUserAgent(),
            'referer_url' => getRefererUrl(),
            'backend_request_url' => getBackendRequestUrl(),
        ];
    }
}
if (!function_exists('getClientHostname')) {
    function getClientHostname(): ?string
    {
        $ip = request()->ip();
        if (!$ip) {
            return null;
        }

        $hostname = gethostbyaddr($ip);

        if ($hostname === $ip) {
            return null;
        }

        return $hostname;
    }
}
if (!function_exists('getClientUserAgent')) {
    function getClientUserAgent(): ?string
    {
        return request()->header('User-Agent') ?? null;
    }
}
if (!function_exists('getRefererUrl')) {
    function getRefererUrl(): ?string
    {
        return request()->header('referer') ?? request()->url();
    }
}
if (!function_exists('getBackendRequestUrl')) {
    function getBackendRequestUrl(): string
    {
        return request()->fullUrl();
    }
}
