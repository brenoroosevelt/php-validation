<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use BrenoRoosevelt\Validation\BelongsToFieldTrait;
use BrenoRoosevelt\Validation\GuardTrait;
use BrenoRoosevelt\Validation\Result;
use BrenoRoosevelt\Validation\Validation;

abstract class AbstractValidation implements Validation
{
    use GuardTrait,
        BelongsToFieldTrait;

    protected string $message;

    public function __construct(?string $message = null)
    {
        $this->message = $message ?? sprintf('Constraint violation: %s', get_class($this));
    }

    public function validate($input, array $context = []): Result
    {
        $result = $this->newEmptyValidationResult();
        return $this->isValid($input, $context) ? $result: $result->add($this->message);
    }

    abstract protected function isValid($input, array $context = []): bool;
}
