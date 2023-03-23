<?php

namespace App\Core\Utils\Failures;

use DateTime;
use Error;
use Exception;
use Throwable;

const DEFAULT_FAILURE_MESSAGES = [
  "Failure" => "The server encountered an error.",
  "ServerFailure" => "The server encountered an error.",
  "BadRequestFailure" => "The request can not be processed.",
  "NotFoundFailure" => "The resource is not found.",
  "ConflictFailure" => "The action produce conflict in our records.",
  "UnauthorizedFailure" => "Authentication required to access this resource.",
  "ForbiddenFailure" => "Access denied for this resource.",
  "UnknownFailure" => "An unknown error occurred.",
];

/**
 * Summary of Failure
 */
abstract class Failure extends Exception
{
  const DEFAULT_VIEW = "_404";
  protected $privateMessage;
  protected $privacy;
  protected $dateTime;
  protected $code;

  public function __constructor(
    string $message = DEFAULT_FAILURE_MESSAGES["Failure"],
    $options = [
      "code" => 0,
    ]
  ) {
    $this->dateTime = new DateTime();

    $this->code = $options["code"];

    parent::__construct($message);
  }

  public function isPrivate()
  {
    return $this->privacy;
  }

  public function getDateTime()
  {
    return $this->dateTime;
  }

  public function getFailureCode()
  {
    return $this->code;
  }

  public function getStatusCode()
  {
    return 500;
  }

  public function getStatusText()
  {
    return "Internal Server Error";
  }

  public function getRaw()
  {
    return [
      "message" => $this->getMessage(),
      "statusCode" => $this->getStatusCode(),
      "statusText" => $this->getStatusText(),
      "code" => $this->getCode(),
      "dateTime" => $this->getDateTime()
    ];
  }
}