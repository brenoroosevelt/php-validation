<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\Contracts\Fieldable;
use BrenoRoosevelt\Validation\BelongsToField;
use BrenoRoosevelt\Validation\Contracts\Prioritable;
use BrenoRoosevelt\Validation\Contracts\Stoppable;
use BrenoRoosevelt\Validation\Priority;
use BrenoRoosevelt\Validation\Contracts\Result;
use BrenoRoosevelt\Validation\Contracts\Rule;
use BrenoRoosevelt\Validation\RuleSetFactory;
use BrenoRoosevelt\Validation\StopOnFailure;

#[Attribute(Attribute::TARGET_PROPERTY)]
class UseRuleSet implements Rule, Fieldable, Stoppable, Prioritable
{
    use BelongsToField, StopOnFailure, Priority;

    public function __construct(
        private object|string $objectOrClass,
        private string $property,
        int $stopOnFailure = Stoppable::DONT_STOP,
        int $priority = Prioritable::LOWEST_PRIORITY
    ) {
        $this->setStopSign($stopOnFailure);
        $this->setPriority($priority);
        $this->setField(null);
    }

    public function validate(mixed $input, array $context = []): Result
    {
        return RuleSetFactory::fromProperty($this->objectOrClass, $this->property)->validate($input, $context);
    }
}
