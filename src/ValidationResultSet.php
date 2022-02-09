<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\Guard;
use BrenoRoosevelt\Validation\Exception\ValidationExceptionInterface;

class ValidationResultSet
{
    use Guard;

    /** @var Result[] */
    private array $validationResults = [];

    public function add(Result ...$results): self
    {
        $instance = clone $this;
        array_push($instance->validationResults, ...$results);
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
        foreach ($this->validationResults as $result) {
            foreach ($result->getErrors() as $error) {
                $field = $result->getField();
                if ($field !== null) {
                    $errors[$field][] = $error;
                } else {
                    $errors[] = $error;
                }
            }
        }

        return $errors;
    }

    /** @return Result[] */
    public function validationResults(): array
    {
        return $this->validationResults;
    }

    public function isEmpty(): bool
    {
        return empty($this->validationResults);
    }

    /**
     * @throws ValidationExceptionInterface
     */
    public function guard(?ValidationExceptionInterface $validationException = null): void
    {
        $this->guardResult($this, $validationException);
    }
}
