<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ForbiddenActionException extends Exception
{
    public function __construct(string $message = "This action is forbidden", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
