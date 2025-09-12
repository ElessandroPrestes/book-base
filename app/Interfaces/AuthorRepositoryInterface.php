<?php

namespace App\Interfaces;

use App\Models\Author;

interface AuthorRepositoryInterface
{
    public function create(array $data): Author;
}
