<?php

namespace App\Core\Utils\Results;

interface ResultInterface
{
    public function get();
    public function isError(): bool;
    public function isSuccess(): bool;
    public function when(?callable $whenError, ?callable $whenSuccess): mixed;
}