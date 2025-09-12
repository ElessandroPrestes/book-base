<?php

namespace App\Repositories;

use App\Interfaces\AuthorRepositoryInterface;
use App\Models\Author;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function create(array $data): Author
    {
        return Author::create($data);
    }
}
