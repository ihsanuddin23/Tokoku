<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'verified.seller' => \App\Http\Middleware\VerifiedSellerMiddleware::class,
            'active' => \App\Http\Middleware\EnsureUserIsActive::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'payment/webhook',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if ($e->getStatusCode() === 503 && $request->expectsJson() === false) {
                return response()->view('maintenance', [], 503);
            }
        });
    })->create();
