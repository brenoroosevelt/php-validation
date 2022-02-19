<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\StopSign;
use Closure;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Generic extends AbstractRule
{
    const MESSAGE = 'Invalid input';

    private Closure $rule;

    public function __construct(
        callable $rule,
        ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP
    ) {
        $this->rule = Closure::fromCallable($rule);
        parent::__construct($message, $stopOnFailure);
    }

    public function isValid($input, array $context = []): bool
    {
        return ($this->rule)($input, $context);
    }
}
