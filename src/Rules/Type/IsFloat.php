<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Type;

use Attribute;
use BrenoRoosevelt\Validation\Rules\AbstractValidation;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsFloat extends AbstractValidation
{
    protected function isValid($input, array $context = []): bool
    {
        return is_float($input);
    }
}
