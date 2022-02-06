<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    private Result $violations;

    public function __construct(
        ValidationResultSet|ValidationResult $violations,
        ?string $message = null,
        $code = 422,
        Throwable $previous = null
    ) {
        $this->violations = $violations;
        parent::__construct($message ?? $this->formatMessage(), $code, $previous);
    }

    /**
     * @return ValidationResult[]
     */
    public function violations(): array
    {
        return
            $this->violations instanceof ValidationResultSet ?
                $this->violations->validationResults() :
                [$this->violations];
    }

    private function formatMessage(): string
    {
        $messages = [];
        foreach ($this->violations() as $violation) {
            $fieldName = $violation instanceof ResultByField ? $violation->getField() : '_error';
            foreach ($violation->getErrors() as $errorForField) {
                $messages[] = "\t - `$fieldName`: $errorForField";
            }
        }

        return "Validation errors:" . PHP_EOL . implode(PHP_EOL, $messages);
    }
}
