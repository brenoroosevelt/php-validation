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

    use ValidateOrFail, BelongsToField, Stop, Priority;

    public function __construct(
        protected ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP,
        int $priority = 0
    ) {
        $this->stopOnFailure = $stopOnFailure;
        $this->priority = $priority;
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
