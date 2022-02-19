<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\ValidateOrFailTrait;

abstract class AbstractRule implements Rule, BelongsToField, Stoppable
{
    const DEFAULT_MESSAGE = 'Constraint violation: %s';

    use ValidateOrFailTrait, BelongsToFieldTrait, StoppableTrait;

    public function __construct(
        protected ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP
    ) {
        $this->message = $message ?? sprintf(self::DEFAULT_MESSAGE, $this->className());
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

    protected function className(): string
    {
        return array_reverse(explode('\\', get_class($this)))[0];
    }

    abstract public function isValid(mixed $input, array $context = []): bool;
}
