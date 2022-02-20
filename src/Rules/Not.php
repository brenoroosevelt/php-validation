<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\Contracts\Prioritable;
use BrenoRoosevelt\Validation\Contracts\Rule;
use BrenoRoosevelt\Validation\StopSign;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Not extends AbstractRule
{
    public function __construct(
        private Rule $rule,
        ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP,
        int $priority = Prioritable::LOWEST_PRIORITY
    ) {
        parent::__construct($message, $stopOnFailure, $priority);
    }

    public function isValid(mixed $input, array $context = []): bool
    {
        return !$this->rule->validate($input, $context)->isOk();
    }
}
