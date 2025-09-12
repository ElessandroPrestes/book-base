<?php

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Model Author', function () {

    it('possui o campo preenchível "name"', function () {
        $autor = new Author(['name' => 'Machado de Assis']);
        expect($autor->name)->toBe('Machado de Assis');
    });

    it('pode estar relacionado a vários livros com dados extras na tabela pivô', function () {
        $autor = Author::factory()->create();
        $livro = Book::factory()->create();

        $autor->books()->attach($livro->id, ['role' => 'Autor']);

        $this->assertDatabaseHas('book_author', [
            'author_id' => $autor->id,
            'book_id' => $livro->id,
            'role' => 'Autor',
        ]);

        expect($autor->books->first()->pivot->role)->toBe('Autor');
    });

});
