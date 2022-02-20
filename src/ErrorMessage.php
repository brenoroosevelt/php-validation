<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Contracts\Error;
use BrenoRoosevelt\Validation\Contracts\Rule;

final class ErrorMessage implements Error
{
    public function __construct(
        private string $message,
        private ?string $field = null,
        private ?Rule $rule = null
    ) {
    }

    /** @inheritDoc */
    public function message(): string
    {
        return $this->message;
    }

    /** @inheritDoc */
    public function field(): ?string
    {
        return $this->field;
    }

    /** @inheritDoc */
    public function rule(): ?Rule
    {
        return $this->rule;
    }
}
