<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::insert([
            ['name' => 'Machado de Assis'],
            ['name' => 'Clarice Lispector'],
            ['name' => 'Jorge Amado'],
            ['name' => 'Graciliano Ramos'],
            ['name' => 'Cecília Meireles'],
        ]);
    }
}
