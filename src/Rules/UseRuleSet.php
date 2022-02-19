<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\BelongsToField;
use BrenoRoosevelt\Validation\BelongsToFieldTrait;
use BrenoRoosevelt\Validation\Priority;
use BrenoRoosevelt\Validation\PriorityTrait;
use BrenoRoosevelt\Validation\Result;
use BrenoRoosevelt\Validation\Rule;
use BrenoRoosevelt\Validation\RuleSetFactory;

#[Attribute(Attribute::TARGET_PROPERTY)]
class UseRuleSet implements Rule, BelongsToField, Priority
{
    use BelongsToFieldTrait, PriorityTrait;

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
