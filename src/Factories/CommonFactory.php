<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Factories;

use BrenoRoosevelt\Validation\Rules\AllowsEmpty;
use BrenoRoosevelt\Validation\Rules\AllowsNull;
use BrenoRoosevelt\Validation\Rules\Generic;
use BrenoRoosevelt\Validation\Rules\NotEmptyString;
use BrenoRoosevelt\Validation\Rules\NotRequired;
use BrenoRoosevelt\Validation\RuleSet;
use BrenoRoosevelt\Validation\Rule;

trait CommonFactory
{
    abstract public function add(Rule|RuleSet ...$rules): static;

    public function check(callable $rule, ?string $message = null): static
    {
        return $this->add(new Generic($rule, $message));
    }

    public function allowsNull(): static
    {
        return $this->add(new AllowsNull);
    }

    public function allowsEmpty(): static
    {
        return $this->add(new AllowsEmpty);
    }

    public function notRequired(): static
    {
        return $this->add(new NotRequired);
    }

    public function notEmptyString(?string $message = null): static
    {
        return $this->add(new NotEmptyString($message));
    }
}
