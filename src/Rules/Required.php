<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Required extends AbstractRule
{
    const MESSAGE = 'This field is required';

    public function isValid(mixed $input, array $context = []): bool
    {
        $field = $this->getField();
        return null !== $field && array_key_exists($field, $context);
    }
}
