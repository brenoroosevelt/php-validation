<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

interface Result
{
    /**
     * @return bool
     */
    public function isOk(): bool;

    /**
     * @return string[]
     */
    public function getErrors(): array;

    /**
     * @return string|null
     */
    public function getField(): ?string;
}
