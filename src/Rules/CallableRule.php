<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Closure;

class CallableRule extends AbstractValidation
{
    private Closure $rule;

    public function __construct(callable $rule, string $message = 'Invalid input')
    {
        $this->rule = Closure::fromCallable($rule);
        parent::__construct($message);
    }

    protected function isValid($input, array $context = []): bool
    {
        return ($this->rule)($input, $context);
    }
}
