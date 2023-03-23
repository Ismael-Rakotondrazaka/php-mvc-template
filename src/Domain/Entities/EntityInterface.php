<?php

namespace App\Domain\Entities;

interface EntityInterface
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public function lock(): void;
    public function isLocked(): bool;
    public function hasErrors(): bool;
    public function getErrors(): array;
    public function hasError(string $attribute): bool;
    public function getError(string $attribute): array;
    public function getFirstError(string $attribute): string;
    public function getRaw();
}
