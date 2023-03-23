<?php

namespace App\Data\Repositories;

use App\Data\Models\UserModel;
use App\Data\Sources\Users\UserSourceInterface;
use App\Domain\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private UserSourceInterface $source;

    public function __construct(UserSourceInterface $source)
    {
        $this->source = $source;
    }

    public function findAll(): array
    {
        return $this->source->findAll();
    }

    public function findById(string $id): UserModel
    {
        return $this->source->findById($id);
    }
    public function findByEmail(string $email): UserModel
    {
        return $this->source->findByEmail($email);
    }
    public function save($id, string $firstName, string $lastName, string $email, string $hashedPassword, $createdAt, $updatedAt): void
    {
        $this->source->save($id, $firstName, $lastName, $email, $hashedPassword, $createdAt, $updatedAt);
    }
}