<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\ValidateOrFailTrait;

abstract class AbstractRule implements Rule, BelongsToField
{
    use ValidateOrFailTrait,
        BelongsToFieldTrait;

    protected string $message;

    public function __construct(?string $message = null)
    {
        $this->message = $message ?? sprintf('Constraint violation: %s', $this->className());
    }

    public function message(): string
    {
        return $this->message;
    }

    /** @inheritDoc */
    public function validate(mixed $input, array $context = []): Result
    {
        return
            $this->isValid($input, $context) ?
                new ErrorReporting :
                (new ErrorReporting)->addError($this->message, $this->getField());
    }

    private function className(): string
    {
        return array_reverse(explode('\\', get_class($this)))[0];
    }

    abstract public function isValid(mixed $input, array $context = []): bool;
}
