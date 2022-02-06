<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class AlwaysOk implements Validation
{
    public function validate($input, array $context = []): Result
    {
        return new ValidationResult;
    }
}
