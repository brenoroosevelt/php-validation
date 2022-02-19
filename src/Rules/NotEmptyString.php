<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotEmptyString extends AbstractRule
{
    const MESSAGE = 'Value should not be left blank';

    public function isValid($input, array $context = []): bool
    {
        return !(new EmptyString)->isValid($input, $context);
    }
}
