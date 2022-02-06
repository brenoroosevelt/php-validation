<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

/**
 * Composite
 */
class ValidationResultSet implements Result
{
    /** @var ValidationResult[] */
    private array $errorResults = [];

    public function add(ValidationResult ...$errorResult): self
    {
        array_push($this->errorResults, ...$errorResult);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isOk(): bool
    {
        foreach ($this->errorResults as $violation) {
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
        foreach ($this->errorResults as $violation) {
            array_push($errors, ...$violation->getErrors());
        }

        return $errors;
    }

    public function errorResults(): array
    {
        return $this->errorResults;
    }
}
