<?php

use App\Models\Subject;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Model Subject', function () {

    it('possui o campo preenchível "description"', function () {
        $assunto = new Subject(['description' => 'Filosofia']);
        expect($assunto->description)->toBe('Filosofia');
    });

    it('pode estar relacionado a vários livros com indicação de assunto principal', function () {
        $assunto = Subject::factory()->create();
        $livro = Book::factory()->create();

        $assunto->books()->attach($livro->id, ['is_primary' => true]);

        $this->assertDatabaseHas('book_subject', [
            'subject_id' => $assunto->id,
            'book_id' => $livro->id,
            'is_primary' => true,
        ]);

        expect((bool) $assunto->books->first()->pivot->is_primary)->toBeTrue();

    });

});
<?php

use App\Models\Subject;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Model Subject', function () {

    it('possui o campo preenchível "description"', function () {
        $assunto = new Subject(['description' => 'Filosofia']);
        expect($assunto->description)->toBe('Filosofia');
    });

    it('pode estar relacionado a vários livros com indicação de assunto principal', function () {
        $assunto = Subject::factory()->create();
        $livro = Book::factory()->create();

        $assunto->books()->attach($livro->id, ['is_primary' => true]);

        $this->assertDatabaseHas('book_subject', [
            'subject_id' => $assunto->id,
            'book_id' => $livro->id,
            'is_primary' => true,
        ]);

        expect((bool) $assunto->books->first()->pivot->is_primary)->toBeTrue();

    });

});
