<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsType extends AbstractValidation
{
    public function __construct(private string $type, ?string $message = null)
    {
        parent::__construct($message ?? sprintf('Invalid type: %s', $this->type));
    }

    protected function isValid($input, array $context = []): bool
    {
        return gettype($input) === $this->type;
    }
}