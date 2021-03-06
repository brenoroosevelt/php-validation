<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Contracts;

interface Rule
{
    /**
     * @param mixed $input
     * @param array $context
     * @return Result
     */
    public function validate(mixed $input, array $context = []): Result;
}
