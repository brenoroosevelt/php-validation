<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Type;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsType extends AbstractRule
{
    public function __construct(private string $type, ?string $message = null)
    {
        parent::__construct($message ?? sprintf('Invalid type: %s', $this->type));
    }

    protected function evaluate($input, array $context = []): bool
    {
        return gettype($input) === $this->type;
    }
}
