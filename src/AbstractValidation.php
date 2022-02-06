<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

abstract class AbstractValidation implements Validation
{
    protected string $message;

    public function __construct(?string $message = null)
    {
        $this->message = $message ?? sprintf('Constraint violation: %s', get_class($this));
    }

    public function validate($input, array $context = []): Result
    {
        return $this->isValid($input, $context) ? new ValidationResult : (new ValidationResult)->add($this->message);
    }

    abstract protected function isValid($input, array $context = []): bool;
}
