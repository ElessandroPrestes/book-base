<?php

use App\Models\Book;
use App\Models\Author;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Model Book', function () {
    it('deve ser criado com sucesso', function () {
        $livro = Book::factory()->create([
            'title' => 'Laravel para Devs',
            'publisher' => 'Codedev',
            'edition' => '1ª',
            'publication_year' => 2025,
            'price' => 99.90,
            'slug' => 'laravel-para-devs',
            'isbn' => '978-85-7522-123-4',
        ]);

        expect($livro->title)->toBe('Laravel para Devs');
        expect(Book::find($livro->id))->not->toBeNull();
    });

    it('deve permitir associação de autores', function () {
        $livro = Book::factory()->create();
        $autores = Author::factory()->count(2)->create();

        $livro->authors()->attach($autores->pluck('id'), ['role' => 'autor']);

        $livro->refresh();
        expect($livro->authors)->toHaveCount(2);
        expect($livro->authors->first()->pivot->role)->toBe('autor');
    });

    it('deve permitir vinculação de assuntos', function () {
        $livro = Book::factory()->create();
        $assuntos = Subject::factory()->count(3)->create();

        $livro->subjects()->attach($assuntos->pluck('id'), ['is_primary' => true]);

        $livro->refresh();
        expect($livro->subjects)->toHaveCount(3);
        expect((bool) $livro->subjects->first()->pivot->is_primary)->toBeTrue();
    });
});