<?php

use App\Exceptions\AuthorCreationException;
use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('AuthorController', function () {
    it('cria um autor com sucesso', function () {
        $response = $this->postJson('/api/v1/authors', ['name' => 'Cecília Meireles']);
        $response->assertCreated()
            ->assertJsonFragment(['name' => 'Cecília Meireles']);
    });

    it('persiste autor no banco e retorna estrutura esperada', function () {
        $payload = ['name' => 'João Cabral de Melo Neto'];

        $response = $this->postJson('/api/v1/authors', $payload);

        $response->assertCreated()
            ->assertJsonStructure([
                'status',
                'message',
                'data' => ['name']
            ])
            ->assertJsonFragment(['name' => $payload['name']]);

        $this->assertDatabaseHas('authors', ['name' => $payload['name']]);
    });

    it('retorna erro ao criar autor sem nome', function () {
        $response = $this->postJson('/api/v1/authors', []);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    });

    it('retorna erro ao criar autor com nome muito longo', function () {
        $response = $this->postJson('/api/v1/authors', ['name' => str_repeat('a', 41)]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    });

    it('retorna erro de negócio ao criar autor', function () {
        $mock = Mockery::mock(AuthorService::class);
        $mock->shouldReceive('store')
            ->once()
            ->andThrow(new AuthorCreationException('Erro interno ao criar autor'));

        $this->app->instance(AuthorService::class, $mock);

        $response = $this->postJson('/api/v1/authors', ['name' => 'Erro']);

        $response->assertStatus(400)
            ->assertJson([
                'status' => 'error',
                'message' => 'Erro interno ao criar autor'
            ]);
    });

    it('retorna erro inesperado ao criar autor', function () {
    $mock = Mockery::mock(AuthorService::class);
    $mock->shouldReceive('store')
         ->once()
         ->andThrow(new \Exception('Erro inesperado'));

    $this->app->instance(AuthorService::class, $mock);

    $response = $this->postJson('/api/v1/authors', ['name' => 'Erro']);

    $response->assertStatus(500)
             ->assertJson([
                 'status' => 'error',
                 'message' => 'Erro interno ao criar autor'
             ]);
});


});
