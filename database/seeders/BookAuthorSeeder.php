<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relations = [
            ['book_id' => 1, 'author_id' => 1, 'role' => 'Primary Author'],
            ['book_id' => 2, 'author_id' => 2, 'role' => 'Primary Author'],
            ['book_id' => 2, 'author_id' => 3, 'role' => 'Co-Author'],
            ['book_id' => 3, 'author_id' => 4, 'role' => 'Primary Author'],
            ['book_id' => 3, 'author_id' => 5, 'role' => 'Co-Author'],
        ];

        foreach ($relations as $relation) {
            Book::find($relation['book_id'])?->authors()->syncWithoutDetaching([
                $relation['author_id'] => ['role' => $relation['role']]
            ]);
        }
    }
}
