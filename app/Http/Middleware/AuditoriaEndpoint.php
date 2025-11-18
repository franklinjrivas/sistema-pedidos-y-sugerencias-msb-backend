<?php

namespace App\Http\Middleware;

use App\Services\AuditoriaSistemaService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuditoriaEndpoint
{
    private AuditoriaSistemaService $auditoriaSistemaService;

    public function __construct(AuditoriaSistemaService $auditoriaSistemaService)
    {
        $this->auditoriaSistemaService = $auditoriaSistemaService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $content = $response->getContent();

        $decoded = null;
        if ($this->isJson($content)) {
            $decoded = json_decode($content, true);
        }

        $statusCode = $response->getStatusCode();
        $responseData = $decoded ?? $content;

        $responseAuditoria = $this->auditoriaSistemaService->save_log_auditoria_endpoint($statusCode, $responseData);

        return $response;
    }

    private function isJson(string $string): bool
    {
        json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }
}
