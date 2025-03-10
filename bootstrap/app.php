<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (App\Exceptions\NYTimesBooks\ApiAuthenticationException $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'error' => $e->getUserMessage(),
                    'troubleshooting' => $e->getTroubleshootingInfo(),
                    'status' => 'error'
                ], Response::HTTP_UNAUTHORIZED);
            }
        });

        $exceptions->renderable(function (App\Exceptions\NYTimesBooks\ApiRateLimitException $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                $response = [
                    'error' => 'Rate limit exceeded',
                    'status' => 'error'
                ];

                if ($e->hasRetryAfter()) {
                    $response['retry_after'] = $e->getRetryAfter();
                }

                return response()->json($response, Response::HTTP_TOO_MANY_REQUESTS);
            }
        });

        $exceptions->renderable(function (App\Exceptions\NYTimesBooks\ApiNotFoundException $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                $response = [
                    'error' => $e->getUserMessage(),
                    'troubleshooting' => $e->getTroubleshootingInfo(),
                    'status' => 'error'
                ];
                
                if ($e->hasResource()) {
                    $response['resource'] = $e->getResource();
                }
                
                if ($e->getErrorCode()) {
                    $response['error_code'] = $e->getErrorCode();
                }
                
                return response()->json($response, Response::HTTP_NOT_FOUND);
            }
        });
        
        $exceptions->renderable(function (App\Exceptions\NYTimesBooks\ApiException $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'error' => 'An error occurred while processing your request',
                    'status' => 'error',
                    'details' => $e->getDetailedErrorInfo()
                ], $e->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });        
    })->create();
