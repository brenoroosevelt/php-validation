<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Contracts;

interface Error
{
    /**
     * @return string
     */
    public function message(): string;

    /**
     * @return string|null
     */
    public function field(): ?string;

    /**
     * @return Rule|null
     */
    public function rule(): ?Rule;
}
