<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Type;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsInstanceOf extends AbstractRule
{
    public function __construct(private string $class, ?string $message = null)
    {
        parent::__construct($message);
    }

    protected function evaluate($input, array $context = []): bool
    {
        return $input instanceof $this->class;
    }
}
