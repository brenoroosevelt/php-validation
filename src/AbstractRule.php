<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\ValidateOrFailTrait;
use BrenoRoosevelt\Validation\Translation\Translator;

abstract class AbstractRule implements Rule, BelongsToField, Stoppable
{
    const MESSAGE = 'Constraint violation (%s)';

    use ValidateOrFailTrait, BelongsToFieldTrait, StoppableTrait;

    public function __construct(
        protected ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP
    ) {
        $this->stopOnFailure = $stopOnFailure;
    }

    public function message(): string
    {
        return $this->message ?? $this->translatedMessage();
    }

    public function translatedMessage(): ?string
    {
        return Translator::translate(static::MESSAGE, $this->className());
    }

    /** @inheritDoc */
    public function validate(mixed $input, array $context = []): Result
    {
        return
            $this->isValid($input, $context) ?
                ErrorReporting::success() :
                (new ErrorReporting)->addError($this->message(), $this->getField(), $this);
    }

    protected function className(): string
    {
        return array_reverse(explode('\\', get_class($this)))[0];
    }

    abstract public function isValid(mixed $input, array $context = []): bool;
}
