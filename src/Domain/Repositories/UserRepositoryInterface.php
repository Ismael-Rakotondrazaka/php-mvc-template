<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function findAll(): array;
    public function findById(string $id): User;
    public function findByEmail(string $email): User;
    public function save(string $id, string $firstName, string $lastName, string $email, string $password, string $createdAt, string $updatedAt): void;
}