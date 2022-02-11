<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\ValidateOrFailTrait;

abstract class AbstractRule implements Rule, BelongsToField, Stopable
{
    use ValidateOrFailTrait, BelongsToFieldTrait, StopableTrait;

    protected string $message;

    public function __construct(?string $message = null, int $stopOnFailure = StopSign::DONT_STOP)
    {
        $this->message = $message ?? sprintf('Constraint violation: %s', $this->className());
        $this->stopOnFailure = $stopOnFailure;
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
                ErrorReporting::success() :
                (new ErrorReporting)->addError($this->message, $this->getField(), $this);
    }

    private function className(): string
    {
        return array_reverse(explode('\\', get_class($this)))[0];
    }

    abstract public function isValid(mixed $input, array $context = []): bool;
}
