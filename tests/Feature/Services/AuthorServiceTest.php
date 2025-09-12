<?php

use App\Exceptions\AuthorCreationException;
use App\Services\AuthorService;
use App\Models\Author;
use App\Interfaces\AuthorRepositoryInterface;

describe('AuthorService', function () {
    it('cria um autor com sucesso via AuthorService', function () {
        $mockRepo = Mockery::mock(AuthorRepositoryInterface::class);
        $mockRepo->shouldReceive('create')
            ->once()
            ->with(['name' => 'Cecília Meireles'])
            ->andReturn(new Author(['name' => 'Cecília Meireles']));

        $service = new AuthorService($mockRepo);

        $autor = $service->store(['name' => 'Cecília Meireles']);

        expect($autor)->toBeInstanceOf(Author::class)
            ->and($autor->name)->toBe('Cecília Meireles');
    });

    it('lança AuthorCreationException ao falhar na criação', function () {
        $mockRepo = Mockery::mock(AuthorRepositoryInterface::class);
        $mockRepo->shouldReceive('create')
            ->once()
            ->with(['name' => 'Erro'])
            ->andThrow(new \Exception('Falha no banco'));

        $service = new AuthorService($mockRepo);

        expect(fn() => $service->store(['name' => 'Erro']))
            ->toThrow(AuthorCreationException::class);
    });
});
