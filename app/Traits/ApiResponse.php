<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function success(mixed $data, string $message = 'Operação realizada com sucesso', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error(string $message = 'Erro interno', int $code = 500): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }

    protected function errorValidation(array $errors, string $message = 'Erro de validação', int $code = 422): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors'  => $errors,
        ], $code, [], JSON_UNESCAPED_UNICODE);
    }
}
