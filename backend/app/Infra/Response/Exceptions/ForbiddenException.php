<?php

namespace App\Infra\Response\Exceptions;

use Exception;

class ForbiddenException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
