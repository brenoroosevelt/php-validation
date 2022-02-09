<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use Closure;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Generic extends AbstractRule
{
    private Closure $rule;

    public function __construct(callable $rule, ?string $message = 'Invalid input')
    {
        $this->rule = Closure::fromCallable($rule);
        parent::__construct($message);
    }

    public function isValid($input, array $context = []): bool
    {
        return ($this->rule)($input, $context);
    }
}
