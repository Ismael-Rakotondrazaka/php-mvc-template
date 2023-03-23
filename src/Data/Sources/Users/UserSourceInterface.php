<?php

namespace App\Data\Sources\Users;

use App\Data\Models\UserModel;

interface UserSourceInterface
{
    public function findAll(): array;
    public function findById(string $id): UserModel;
    public function findByEmail(string $email): UserModel;
    public function save(string $id, string $firstName, string $lastName, string $email, string $hashedPassword, string $createdAt, string $updatedAt): void;
}