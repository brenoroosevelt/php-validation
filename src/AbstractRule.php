<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\ValidateOrFail;

/**
 * helper class to create single message validations
 */
abstract class AbstractRule implements Rule
{
    use ValidateOrFail,
        MaybeBelongsToField;

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
        $result = $this->newEmptyValidationResult();
        return $this->evaluate($input, $context) ? $result : $result->error($this->message);
    }

    /**
     * @param mixed $input
     * @param array $context
     * @return bool
     */
    public function isValid(mixed $input, array $context = []): bool
    {
        return $this->evaluate($input, $context);
    }

    /**
     * @param mixed $input
     * @param array $context
     * @return bool
     */
    abstract protected function evaluate(mixed $input, array $context = []): bool;
}
