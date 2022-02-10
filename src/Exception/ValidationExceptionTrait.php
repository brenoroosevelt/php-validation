<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Error;
use BrenoRoosevelt\Validation\ErrorMessage;
use BrenoRoosevelt\Validation\Rule;

trait ValidationExceptionTrait
{
    /** @var Error[] */
    protected array $errors = [];

    public function addError(string $message, Rule $rule, ?string $field = null): void
    {
        $this->errors[] = new ErrorMessage($message, $rule, $field);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
