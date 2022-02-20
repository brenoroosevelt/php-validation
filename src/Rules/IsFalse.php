<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY|Attribute::TARGET_METHOD)]
class IsFalse extends AbstractRule
{
    const MESSAGE = 'Value should be false';

    public function isValid($input, array $context = []): bool
    {
        return $input === false;
    }
}
