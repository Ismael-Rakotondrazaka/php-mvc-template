<?php

namespace App\Domain\Entities;

use DateTime;
use Exception;

abstract class User implements EntityInterface
{
    const ID_LENGTH = 21;
    const ID_CHARACTERS = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_";

    private string $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private string $hashedPassword;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    private array $errors;
    private bool $locked;

    public function __construct($id, $firstName, $lastName, $email, $password, $hashedPassword, DateTime $createdAt, DateTime $updatedAt)
    {
        if (!$password && !$hashedPassword) {
            throw new Exception("need password or hashed password");
        }
        $this->id = $this->validateId($id);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;

        if ($password) {
            $this->password = $password;
            $this->hashedPassword = $this->hashPassword($password);
        } else {
            $this->hashedPassword = $hashedPassword;
            $this->hashedPassword = $this->decryptPassword($password);
        }

        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    private function validateId($id)
    {
        return $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        if ($this->locked) {
            throw new Exception("instance locked");
        }

        return $this->password;
    }

    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }

    protected function hashPassword($password)
    {
        return strrev($password);
    }

    protected function decryptPassword($hashedPassword)
    {
        return strrev($hashedPassword);
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getRaw()
    {
        return [
            "id" => $this->getId(),
            "name" => [
                "first" => $this->getFirstName(),
                "last" => $this->getLastName(),
                "full" => $this->getFullName()
            ],
            "email" => $this->getEmail(),
            "createdAt" => $this->getCreatedAt(),
            "updatedAt" => $this->getUpdatedAt()
        ];
    }

    public function lock(): void
    {
        $this->locked = true;
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function hasErrors(): bool
    {
        return count($this->errors) === 1;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasError(string $attribute): bool
    {
        return !!$this->errors[$attribute];
    }

    public function getError(string $attribute): array
    {
        return $this->errors[$attribute];
    }

    public function getFirstError(string $attribute): string
    {
        return $this->errors[$attribute][0];
    }
}