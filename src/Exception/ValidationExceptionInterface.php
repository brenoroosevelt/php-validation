<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Exception;

use Throwable;

interface ValidationExceptionInterface extends Throwable
{
    /**
     * @param string $error
     * @param string|null $field
     * @return void
     */
    public function addError(string $error, ?string $field = null): void;

    /**
     * @return array
     */
    public function getErrors(): array;
}
