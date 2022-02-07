<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsInstanceOf extends AbstractValidation
{
    public function __construct(private string $pattern, ?string $message = null)
    {
        parent::__construct($message);
    }

    protected function isValid($input, array $context = []): bool
    {
        return $input instanceof $this->pattern;
    }
}
