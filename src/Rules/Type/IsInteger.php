<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Type;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsInteger extends TypeRule
{
    public function isValid($input, array $context = []): bool
    {
        return is_integer($input);
    }
}
