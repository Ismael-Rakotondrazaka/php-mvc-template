<?php

namespace App\Core\Utils\Results;


class ErrorResult implements ResultInterface
{
    private $error;

    public function __constructor($error)
    {
        $this->error = $error;
    }

    public function get()
    {
        return $this->error;
    }

    public function isError(): bool
    {
        return true;
    }

    public function isSuccess(): bool
    {
        return false;
    }

    public function when(?callable $whenError, ?callable $whenSuccess): mixed
    {
        return call_user_func($whenError, $this->error);
    }
}