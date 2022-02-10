<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Error;
use Exception;
use Throwable;

class ValidationException extends Exception implements ValidationExceptionInterface
{
    /** @var Error[] */
    private array $errors;

    public function __construct(array $errors, string $message = "", int $code = 422, ?Throwable $previous = null)
    {
        $this->errors = array_filter($errors, fn($e) => $e instanceof Error);
        parent::__construct($message, $code, $previous);
    }

    /** @inheritDoc */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
