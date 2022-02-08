<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Factories;

use BrenoRoosevelt\Validation\Rules\Generic;
use BrenoRoosevelt\Validation\RuleSet;
use BrenoRoosevelt\Validation\Rule;

trait CommonFactory
{
    abstract public function add(Rule|RuleSet ...$rules): RuleSet;

    public function check(callable $rule, ?string $message = null): RuleSet
    {
        return $this->add(new Generic($rule, $message));
    }
}
