<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Email extends AbstractRule
{
    const MESSAGE = 'Invalid e-mail';

    public function isValid($input, array $context = []): bool
    {
        return
            is_string($input) &&
            filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
    }
}
