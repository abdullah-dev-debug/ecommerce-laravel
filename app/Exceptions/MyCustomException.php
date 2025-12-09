<?php

namespace App\Exceptions;

use Exception;

class MyCustomException extends Exception
{
    protected int $statusCode;

    public function __construct(string $message = "", int $statusCode = 404)
    {
        parent::__construct($message, $statusCode);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
    