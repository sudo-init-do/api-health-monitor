<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: __DIR__ . '/../routes/health.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register route middleware aliases here
        $middleware->alias([
            'api.key' => \App\Http\Middleware\ApiKeyGuard::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Always return JSON for API requests
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                $status = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;

                return response()->json([
                    'message'   => $e->getMessage(),
                    'exception' => class_basename($e),
                ], $status);
            }
        });
    })
    ->create();
