<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Type;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsNumeric extends AbstractRule
{
    protected function evaluate($input, array $context = []): bool
    {
        return is_numeric($input);
    }
}
