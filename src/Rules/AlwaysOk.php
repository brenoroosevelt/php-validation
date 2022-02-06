<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use BrenoRoosevelt\Validation\Result;
use BrenoRoosevelt\Validation\Validation;
use BrenoRoosevelt\Validation\ValidationResult;

class AlwaysOk implements Validation
{
    public function validate($input, array $context = []): Result
    {
        return ValidationResult::everythingIsOk();
    }
}
