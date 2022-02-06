<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

interface Result
{
    /**
     * @return string[]
     */
    public function getErrors(): array;

    /**
     * @return bool
     */
    public function isOk(): bool;
}
