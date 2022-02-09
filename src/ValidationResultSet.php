<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

class ValidationResultSet
{
    /** @var ValidationResult[] */
    private array $validationResults = [];

    public function add(ValidationResult ...$errorResult): self
    {
        $instance = clone $this;
        array_push($instance->validationResults, ...$errorResult);
        return $instance;
    }

    public function isOk(): bool
    {
        foreach ($this->validationResults as $violation) {
            if (!$violation->isOk()) {
                return false;
            }
        }

        return true;
    }

    public function getErrors(): array
    {
        $errors = [];
        foreach ($this->validationResults as $violation) {
            if (null === ($field = $violation->getField())) {
                array_push($errors, ...$violation->getErrors());
                continue;
            }

            if (!isset($errors[$field])) {
                $errors[$field] = [];
            }

            array_push($errors[$field], ...$violation->getErrors());
        }

        return $errors;
    }

    public function validationResults(): array
    {
        return $this->validationResults;
    }

    public function isEmpty(): bool
    {
        return empty($this->validationResults);
    }
}
