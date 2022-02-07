<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotNull extends AbstractValidation
{
    protected function evaluate($input, array $context = []): bool
    {
        return !is_null($input);
    }
}
