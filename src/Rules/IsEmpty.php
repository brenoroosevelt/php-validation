<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY|Attribute::TARGET_METHOD)]
class IsEmpty extends AbstractRule
{
    protected function evaluate($input, array $context = []): bool
    {
        if (is_object($input)) {
            return false;
        }

        if (is_array($input) && empty($input)) {
            return true;
        }

        if (is_string($input) && mb_strlen(trim($input)) === 0) {
            return true;
        }

        return false;
    }
}
