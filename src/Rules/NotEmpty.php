<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractValidation;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotEmpty extends AbstractValidation
{
    protected function evaluate($input, array $context = []): bool
    {
        return !empty($input);
    }
}
