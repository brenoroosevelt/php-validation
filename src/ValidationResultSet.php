<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

/**
 * Composite
 */
class ValidationResultSet implements Result
{
    /** @var ValidationResult[] */
    private array $validationResults = [];

    public function add(ValidationResult ...$errorResult): self
    {
        array_push($this->validationResults, ...$errorResult);
        return $this;
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
