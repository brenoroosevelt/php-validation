<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\Contracts\Fieldable;
use BrenoRoosevelt\Validation\BelongsToField;
use BrenoRoosevelt\Validation\Contracts\Prioritable;
use BrenoRoosevelt\Validation\Priority;
use BrenoRoosevelt\Validation\Contracts\Result;
use BrenoRoosevelt\Validation\Contracts\Rule;
use BrenoRoosevelt\Validation\RuleSetFactory;

#[Attribute(Attribute::TARGET_PROPERTY)]
class UseRuleSet implements Rule, Fieldable, Prioritable
{
    use BelongsToField, Priority;

    public function __construct(
        private object|string $objectOrClass,
        private string $property,
        int $priority = 0
    ) {
        $this->priority = $priority;
    }

    public function validate(mixed $input, array $context = []): Result
    {
        return RuleSetFactory::fromProperty($this->objectOrClass, $this->property)->validate($input, $context);
    }
}
