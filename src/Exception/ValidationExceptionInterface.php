<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Error;
use BrenoRoosevelt\Validation\Rule;
use Throwable;

interface ValidationExceptionInterface extends Throwable
{
    /**
     * @param string $message
     * @param Rule $rule
     * @param string|null $field
     * @return void
     */
    public function addError(string $message, Rule $rule, ?string $field = null): void;

    /**
     * @return Error[]
     */
    public function getErrors(): array;
}
