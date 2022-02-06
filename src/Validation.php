<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

interface Validation
{
    public function validate($input, array $context = []): Result;
}
