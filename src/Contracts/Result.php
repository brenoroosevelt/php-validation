<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Contracts;

interface Result
{
    /**
     * @return bool
     */
    public function isOk(): bool;

    /**
     * @return Error[]
     */
    public function getErrors(): array;
}
