<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotEmpty extends AbstractRule
{
    const MESSAGE = 'Value should not be null';

    public function isValid($input, array $context = []): bool
    {
        return !(new IsEmpty)->isValid($input, $context);
    }
}
