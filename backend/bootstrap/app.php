<?php

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('public')
                ->prefix('public')
                ->name('public.')
                ->group(__DIR__ . '/../routes/public.php');
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'validate.user' => \App\Http\Middleware\UserValidator::class,
        ]);

        $middleware->api(prepend: [
            \App\Http\Middleware\JwtValidator::class,
        ]);

        $middleware->group('public', [
            \Illuminate\Routing\Middleware\ThrottleRequests::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $message = '';

            if ($e instanceof UnauthorizedException) {
                $code = Response::HTTP_FORBIDDEN;
                $message = 'No tienes permiso para acceder a este recurso';
            } else if ($e instanceof NotFoundHttpException) {
                $code = Response::HTTP_NOT_FOUND;
                $message = 'La ruta solicitada no existe';
            } else if ($e instanceof MethodNotAllowedHttpException) {
                error_log($e);
                $code = Response::HTTP_METHOD_NOT_ALLOWED;
                $message = 'El método de la petición no es válido';
            } else if ($e instanceof QueryException) {
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
                $message = 'Ha ocurrido un error inesperado';
            }

            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => $e->getMessage(),
            ], $code);
        });
    })->create();
