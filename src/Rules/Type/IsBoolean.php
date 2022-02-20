<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Type;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsBoolean extends TypeRule
{
    public function isValid($input, array $context = []): bool
    {
        return is_bool($input);
    }
}
