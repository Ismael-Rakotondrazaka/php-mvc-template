<?php

namespace App\Core\Utils\Failures;

class NotFoundFailure extends Failure
{
    const DEFAULT_VIEW = "_404";
    const STATUS_CODE = 404;
    private $statusText = "Not Found";

    public function __constructor(
        $message = DEFAULT_FAILURE_MESSAGES["NotFoundFailure"],
        $options = [
            "isPrivate" => false,
            "code" => 1,
        ]
    ) {
        parent::__constructor($message, $options);
    }

    public function getStatusCode()
    {
        return self::STATUS_CODE;
    }

    public function getStatusText()
    {
        return $this->statusText;
    }
}