<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use BrenoRoosevelt\Validation\Error;
use Throwable;

interface ValidationExceptionInterface extends Throwable
{
    /**
     * @param string $message
     * @param string|null $field
     * @return void
     */
    public function addError(string $message, ?string $field = null): void;

    /**
     * @return Error[]
     */
    public function getErrors(): array;
}
