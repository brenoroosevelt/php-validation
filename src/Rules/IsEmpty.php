<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY|Attribute::TARGET_METHOD)]
class IsEmpty extends AbstractRule
{
    protected function evaluate($input, array $context = []): bool
    {
        return empty($input);
    }
}
