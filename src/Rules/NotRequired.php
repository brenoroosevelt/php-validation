<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\Result;
use BrenoRoosevelt\Validation\Validation;
use BrenoRoosevelt\Validation\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotRequired implements Validation
{
    public function validate(mixed $input, array $context = []): Result
    {
        return new ValidationResult;
    }
}
