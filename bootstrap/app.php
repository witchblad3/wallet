<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Services\Wallet\Exceptions\InsufficientFundsException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (InsufficientFundsException $e, $request) {
            return response()->json(['message' => $e->getMessage()], 409);
        });

        $exceptions->render(function (ModelNotFoundException|NotFoundHttpException $e, $request) {
            return response()->json(['message' => 'Ресурс не найден'], 404);
        });

        $exceptions->render(function (ValidationException $e, $request) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors'  => $e->errors(),
            ], 422);
        });

        $exceptions->render(function (\Throwable $e, $request) {
            if (str_starts_with($request->getPathInfo(), '/api')) {
                return response()->json(['message' => 'Внутренняя ошибка'], 500);
            }
        });
    })->create();
