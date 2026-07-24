<?php

namespace App\Exceptions;

use Exception;

class BusinessException extends Exception
{
    /**
     * HTTP Status Code
     */
    protected int $statusCode;

    /**
     * Additional Errors
     */
    protected mixed $errors;

    public function __construct(string $message, int $statusCode = 400, mixed $errors = null)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
        $this->errors = $errors;
    }


    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrors(): mixed
    {
        return $this->errors;
    }
}
