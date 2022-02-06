<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\Rules\AbstractValidation;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Integer extends AbstractValidation
{
    protected function isValid($input, array $context = []): bool
    {
        return is_integer($input);
    }
}
