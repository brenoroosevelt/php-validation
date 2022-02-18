<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Required extends AbstractRule
{
    public function isValid(mixed $input, array $context = []): bool
    {
       return true;
    }
}
