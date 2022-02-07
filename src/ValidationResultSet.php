<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

/**
 * Composite, Immutable
 */
class ValidationResultSet implements Result
{
    /** @var ValidationResult[] */
    private array $validationResults = [];

    public function add(ValidationResult ...$errorResult): self
    {
        $instance = clone $this;
        array_push($instance->validationResults, ...$errorResult);
        return $instance;
    }

    /**
     * @inheritDoc
     */
    public function isOk(): bool
    {
        foreach ($this->validationResults as $violation) {
            if (!$violation->isOk()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        $errors = [];
        foreach ($this->validationResults as $violation) {
            array_push($errors, ...$violation->getErrors());
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
