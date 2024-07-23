<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;

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
        $exceptions->render(function (Throwable $e) {
            $message = $e->getMessage();
            if ($e instanceof NotFoundHttpException) {
                $message = "Resource not found";
            }

            if ($e instanceof ValidationException) {
                $message = [];
                foreach($e->errors() as $key => $value) {
                    $message[] = $value[0];
                }

                $message = implode('<br>', $message);
            }

            return response()
                ->json([
                    'success' => false,
                    'message' => $message
                ]);
        });
    })->create();
