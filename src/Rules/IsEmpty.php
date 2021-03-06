<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY|Attribute::TARGET_METHOD)]
class IsEmpty extends AbstractRule
{
    const MESSAGE = 'Value should be empty';

    public function isValid($input, array $context = []): bool
    {
        if (is_object($input)) {
            return false;
        }

        if ((is_array($input) || is_string($input)) && empty($input)) {
            return true;
        }

        return false;
    }
}
