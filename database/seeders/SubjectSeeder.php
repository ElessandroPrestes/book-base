<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;


class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::insert([
            ['description' => 'Software Engineering'],
            ['description' => 'Programming'],
            ['description' => 'Refactoring'],
            ['description' => 'Best Practices'],
        ]);
    }
}
