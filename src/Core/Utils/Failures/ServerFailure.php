<?php

namespace App\Core\Utils\Failures;

class ServerFailure extends Failure
{
  const DEFAULT_VIEW = "_500";
  const STATUS_CODE = 500;
  private $statusText = "Internal Server Error";

  public function __constructor(
    $message = DEFAULT_FAILURE_MESSAGES["ServerFailure"],
    $options = [
      "isPrivate" => false,
      "code" => 1,
    ]
  ) {
    parent::__constructor($message, $options);
  }

  public function getStatusCode()
  {
    return self::DEFAULT_VIEW;
  }

  public function getStatusText()
  {
    return $this->statusText;
  }
}