<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\ValidateOrFail;

abstract class AbstractRule implements Rule
{
    use ValidateOrFail,
        BelongsToField;

    protected string $message;

    public function __construct(?string $message = null)
    {
        $this->message = $message ?? sprintf('Constraint violation: %s', get_class($this));
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $input, array $context = []): Result
    {
        $result = $this->newEmptyResult();
        return $this->isValid($input, $context) ? $result : $result->addError($this->message);
    }

    abstract public function isValid(mixed $input, array $context = []): bool;
}
