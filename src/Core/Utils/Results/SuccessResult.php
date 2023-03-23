<?php

namespace App\Core\Utils\Results;


class SuccessResult implements ResultInterface
{
    private $success;

    public function __constructor($success)
    {
        $this->success = $success;
    }

    public function get()
    {
        return $this->success;
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
        return call_user_func($whenSuccess, $this->success);
    }
}