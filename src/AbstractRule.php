<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Contracts\Fieldable;
use BrenoRoosevelt\Validation\Contracts\Prioritable;
use BrenoRoosevelt\Validation\Contracts\Result;
use BrenoRoosevelt\Validation\Contracts\Rule;
use BrenoRoosevelt\Validation\Contracts\Stoppable;
use BrenoRoosevelt\Validation\Exception\ValidateOrFail;
use BrenoRoosevelt\Validation\Translation\Translator;

abstract class AbstractRule implements Rule, Fieldable, Stoppable, Prioritable
{
    const MESSAGE = 'Constraint violation (%s)';

    use ValidateOrFail, BelongsToField, StopOnFailure, Priority;

    public function __construct(
        protected ?string $message = null,
        ?int $stopOnFailure = null,
        ?int $priority = null
    ) {
        $this->setStopSign($stopOnFailure ?? Stoppable::DONT_STOP);
        $this->setPriority($priority ?? Prioritable::LOWEST_PRIORITY);
        $this->setField(null);
    }

    public function message(): string
    {
        return $this->message ?? $this->translatedMessage();
    }

    private function hasOwnMessage(): bool
    {
        return static::MESSAGE !== self::MESSAGE;
    }

    public function translatedMessage(): ?string
    {
        return
            $this->hasOwnMessage() ?
                Translator::translate(static::MESSAGE) :
                Translator::translate(static::MESSAGE, $this->className());
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
