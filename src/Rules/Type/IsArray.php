<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Type;

use Attribute;
use BrenoRoosevelt\Validation\AbstractValidation;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsArray extends AbstractValidation
{
    protected function evaluate($input, array $context = []): bool
    {
        return is_string($input);
    }
}