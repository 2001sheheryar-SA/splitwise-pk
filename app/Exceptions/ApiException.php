<?php

namespace App\Exceptions;

use Exception;

/**
 * Base class for application-level exceptions that should be
 * translated into a consistent JSON API error response.
 */
class ApiException extends Exception
{
    protected int $statusCode = 500;

    public function __construct(string $message = 'An error occurred.', int $statusCode = 500)
    {
        parent::__construct($message);

        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
