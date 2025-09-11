<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::insert([
            [
                'title' => 'Clean Code',
                'publisher' => 'Prentice Hall',
                'edition' => '1st Edition',
                'publication_year' => '2008',
                'price' => 129.90,
                'slug' => Str::slug('Clean Code'),
                'isbn' => '978-0132350884',
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'publisher' => 'Addison-Wesley',
                'edition' => '20th Anniversary Edition',
                'publication_year' => '2019',
                'price' => 149.00,
                'slug' => Str::slug('The Pragmatic Programmer'),
                'isbn' => '978-0201616224',
            ],
            [
                'title' => 'Refactoring',
                'publisher' => 'Addison-Wesley',
                'edition' => '2nd Edition',
                'publication_year' => '2018',
                'price' => 139.50,
                'slug' => Str::slug('Refactoring'),
                'isbn' => '978-0134757599',
            ],
        ]);

        
    }
}
