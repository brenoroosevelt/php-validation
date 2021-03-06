<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY|Attribute::TARGET_METHOD)]
class EmptyString extends AbstractRule
{
    const MESSAGE = 'Value should be blank';

    public function isValid($input, array $context = []): bool
    {
        return (is_string($input) && mb_strlen(trim($input)) === 0);
    }
}
