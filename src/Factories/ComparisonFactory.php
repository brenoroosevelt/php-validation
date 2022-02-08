<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Factories;

use BrenoRoosevelt\Validation\Rules\Comparison\Equal;
use BrenoRoosevelt\Validation\RuleSet;
use BrenoRoosevelt\Validation\Rule;

trait ComparisonFactory
{
    abstract public function add(Rule|RuleSet ...$rules): RuleSet;

    public function equal($value, ?string $message = null): RuleSet
    {
        return $this->add(new Equal($value, $message));
    }
}
