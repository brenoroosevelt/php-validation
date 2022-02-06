<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsString extends AbstractValidation
{
    protected function isValid($input, array $context = []): bool
    {
        return is_string($input);
    }
}
