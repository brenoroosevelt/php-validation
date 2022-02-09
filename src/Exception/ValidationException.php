<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use Exception;

class ValidationException extends Exception implements ValidationExceptionInterface
{
    private array $errors = [];

    public function formatMessage(): string
    {
        $messages = [];
        foreach ($this->errors as $fieldName => $error) {
            foreach ($error->getErrors() as $errorForField) {
                $messages[] = "\t - `$fieldName`: $errorForField";
            }
        }

        return $this->getMessage() . ":" . PHP_EOL . implode(PHP_EOL, $messages);
    }

    /**
     * @inheritDoc
     */
    public function addError(string $error, ?string $field = null): void
    {
        if ($field !== null) {
            $this->errors[$field][] = $error;
        } else {
            $this->errors[] = $error;
        }
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
