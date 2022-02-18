<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\Result;
use BrenoRoosevelt\Validation\Rule;
use BrenoRoosevelt\Validation\RuleSetFactory;

#[Attribute(Attribute::TARGET_PROPERTY)]
class RulesOf implements Rule
{
    public function __construct(private object|string $objectOrClass, private string $property)
    {
    }

    public function validate(mixed $input, array $context = []): Result
    {
        return RuleSetFactory::fromProperty($this->objectOrClass, $this->property)->validate($input, $context);
    }
}