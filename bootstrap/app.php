<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\App\Exceptions\BusinessLogicException $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage(),
            ]);
        });

        $exceptions->render(function (Throwable $e) {
            if (config('app.debug')) {
                return null;
            }

            $status = 500;
            $headers = [];

            if ($e instanceof HttpExceptionInterface) {
                $status  = $e->getStatusCode();
                $headers = $e->getHeaders();
            }

            return response()->json([
                'success' => false,
                'mensaje' => 'Error en el servidor. Inténtelo más tarde...',
            ], $status, $headers);
        });
    })->create();
