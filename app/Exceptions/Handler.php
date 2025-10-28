<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Services\Wallet\Exceptions\InsufficientFundsException;

class Handler extends ExceptionHandler
{
    /**
     * Для API всегда отдаём JSON.
     */
    public function render($request, Throwable $e)
    {
        if ($request->expectsJson() || $request->is('api/*')) {

            // 422 — валидация
            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors'  => $e->errors(),
                ], 422);
            }

            // 404 — модель/роут не найден
            if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'Not Found',
                ], 404);
            }

            // 401 — неавторизован (если будет нужна авторизация)
            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'message' => 'Unauthenticated',
                ], 401);
            }

            // 409 — бизнес-конфликты кошелька
            if ($e instanceof InsufficientFundsException) {
                return response()->json([
                    'message' => $e->getMessage(), // "Недостаточно средств ..."
                ], 409);
            }

            // Если где-то бросили HttpResponseException вручную — уважаем
            if ($e instanceof HttpResponseException) {
                return $e->getResponse();
            }

            // 400 — прочие предсказуемые ошибки (Runtime/Logic и т.д.) — на твой вкус
            // Можно оставить 500, но часто удобнее разделять.
            if ($e instanceof \InvalidArgumentException || $e instanceof \DomainException) {
                return response()->json([
                    'message' => $e->getMessage() ?: 'Bad Request',
                ], 400);
            }

            // 500 — по умолчанию
            return response()->json([
                'message' => config('app.debug')
                    ? $e->getMessage()
                    : 'Server error',
            ], 500);
        }

        return parent::render($request, $e);
    }
}
