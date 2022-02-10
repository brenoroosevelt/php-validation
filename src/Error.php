<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

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
     * @return Rule
     */
    public function rule(): Rule;
}
