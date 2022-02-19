<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY|Attribute::TARGET_METHOD)]
class NotNull extends AbstractRule
{
    const MESSAGE = 'Value should not be null';

    public function isValid($input, array $context = []): bool
    {
        return !is_null($input);
    }
}
