<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = 'book ' . fake()->unique()->word() . ' ' . fake()->word();

        return [
            'title' => $title,
            'publisher' => 'Editora Exemplo',
            'edition' => '1ª',
            'publication_year' => fake()->year(),
            'price' => fake()->randomFloat(2, 10, 200),
            'slug' => Str::slug($title),
            'isbn' => '978-3-16-' . rand(100000, 999999) . '-' . rand(0, 9),
        ];
    }
}
