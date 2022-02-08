<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Type;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsInstanceOfAny extends AbstractRule
{
    public function __construct(private array $classes, ?string $message = null)
    {
        parent::__construct($message);
    }

    protected function evaluate($input, array $context = []): bool
    {
        foreach ($this->classes as $class) {
            if ($input instanceof $class) {
                return true;
            }
        }

        return false;
    }
}
