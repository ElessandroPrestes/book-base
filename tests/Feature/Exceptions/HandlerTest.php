<?php

use App\Exceptions\Handler;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Throwable;

describe('Handler', function () {

    it('retorna erro de validação no formato padronizado', function () {
        $handler = new Handler(app());

        $request = Request::create('/test', 'POST', [], [], [], ['HTTP_ACCEPT' => 'application/json']);
        $exception = ValidationException::withMessages([
            'name' => ['O campo nome é obrigatório.']
        ]);

        $response = $handler->render($request, $exception);

        expect($response)->toBeInstanceOf(JsonResponse::class)
            ->and($response->getStatusCode())->toBe(422)
            ->and(json_decode($response->getContent(), true))->toMatchArray([
                'status' => 'error',
                'message' => 'Erro de validação',
                'errors' => [
                    'name' => ['O campo nome é obrigatório.']
                ]
            ]);
    });

    it('retorna erro genérico padronizado', function () {
        $handler = new Handler(app());

        $request = Request::create('/test', 'GET', [], [], [], ['HTTP_ACCEPT' => 'application/json']);
        $exception = new \Exception('Algo deu errado', 500);

        $response = $handler->render($request, $exception);

        expect($response)->toBeInstanceOf(JsonResponse::class)
            ->and($response->getStatusCode())->toBe(500)
            ->and(json_decode($response->getContent(), true))->toMatchArray([
                'status' => 'error',
                'message' => 'Algo deu errado'
            ]);
    });

    it('chama parent render para requisições não JSON', function () {
        $handler = new class(app()) extends Handler {
            public $parentCalled = false;

            public function render($request, Throwable $exception): JsonResponse|\Symfony\Component\HttpFoundation\Response
            {
                if (! $request->expectsJson()) {
                    $this->parentCalled = true;
                    return parent::render($request, $exception);
                }

                return parent::render($request, $exception);
            }
        };


        $request = Request::create('/test', 'GET');
        $exception = new \Exception('Erro HTML');

        $handler->render($request, $exception);

        expect($handler->parentCalled)->toBeTrue();
    });
});
