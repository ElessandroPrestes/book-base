<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * Personaliza a resposta JSON para erros de validação.
     */
    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        // Usa o método do trait ApiResponse para padronizar
        return $this->errorValidation($exception->errors());
    }

    /**
     * Renderiza todas as exceções em JSON usando ApiResponse.
     */
    public function render($request, Throwable $exception): JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        if ($request->expectsJson()) {

            // Se for ValidationException, usa invalidJson
            if ($exception instanceof ValidationException) {
                return $this->invalidJson($request, $exception);
            }

            // Outros erros genéricos
            $statusCode = ($exception->getCode() >= 100 && $exception->getCode() <= 599)
                ? $exception->getCode()
                : 500;

            $message = $exception->getMessage() ?: 'Erro interno';

            return $this->error($message, $statusCode);
        }

        // Para requisições normais (HTML), mantém o comportamento padrão
        return parent::render($request, $exception);
    }
}
