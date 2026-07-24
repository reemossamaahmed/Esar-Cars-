<?php

use App\Exceptions\BusinessException;
use App\Http\Responses\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api([\App\Http\Middleware\SetLocale::class,]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (ValidationException $e, $request){
            if($request->expectsJson()){

                return ApiResponse::error(
                    message: __('messages.validation_failed'),
                    code: 422,
                    errors: $e->errors()
                );

            }
        });

        $exceptions->render(function (BusinessException $e, $request) {

            if ($request->expectsJson()) {

                return ApiResponse::error(
                    message: $e->getMessage(),
                    code: $e->getStatusCode(),
                    errors: $e->getErrors()
                );

            }

        });

        $exceptions->render(function (AuthenticationException $e, $request) {

            App::setLocale(
                $request->header('Accept-Language', config('app.locale'))
            );

            return ApiResponse::error(
                __('auth.unauthenticated'),
                401
            );

        });

        $exceptions->render(function (AuthorizationException $e, $request) {

            if ($request->expectsJson()) {

                return ApiResponse::error(
                    message: __('auth.unauthorized'),
                    code: 403,
                );

            }

        });

        $exceptions->render(function (ModelNotFoundException $e, $request) {

            if ($request->expectsJson()) {

                return ApiResponse::error(
                    message: __('messages.resource_not_found'),
                    code: 404,
                );

            }

        });

        $exceptions->render(function (NotFoundHttpException $e, $request) {

            if ($request->expectsJson()) {

                return ApiResponse::error(
                    message: __('messages.route_not_found'),
                    code: 404,
                );

            }

        });

        $exceptions->render(function (Throwable $e, $request) {

            if (! $request->expectsJson()) {
                return null;
            }

            report($e);

            return ApiResponse::error(
                message: config('app.debug')
                    ? $e->getMessage()
                    : __('messages.server_error'),
                code: 500,
            );

        });




    })->create();
