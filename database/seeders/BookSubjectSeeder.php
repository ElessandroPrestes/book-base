<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relations = [
            ['book_id' => 1, 'subject_id' => 1, 'is_primary' => true],
            ['book_id' => 1, 'subject_id' => 4, 'is_primary' => false],
            ['book_id' => 2, 'subject_id' => 2, 'is_primary' => false],
            ['book_id' => 2, 'subject_id' => 4, 'is_primary' => false],
            ['book_id' => 3, 'subject_id' => 3, 'is_primary' => false],
        ];

        foreach ($relations as $relation) {
            Book::find($relation['book_id'])?->subjects()->syncWithoutDetaching([
                $relation['subject_id'] => ['is_primary' => $relation['is_primary']]
            ]);
        }
    }
}
