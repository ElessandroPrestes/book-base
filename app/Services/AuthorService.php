<?php

namespace App\Services;

use App\Exceptions\AuthorCreationException;
use App\Interfaces\AuthorRepositoryInterface;
use App\Models\Author;

class AuthorService
{
    public function __construct(protected AuthorRepositoryInterface $repository) {}

    public function store(array $data): Author
    {
        try {
            return $this->repository->create($data);
        } catch (\Throwable $e) {
            throw new AuthorCreationException('Erro ao criar autor', 0, $e);
        }
    }
}
