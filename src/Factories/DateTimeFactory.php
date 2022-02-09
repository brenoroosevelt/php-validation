<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Factories;

use BrenoRoosevelt\Validation\Rules\DateTime\CurrentDay;
use BrenoRoosevelt\Validation\Rules\DateTime\CurrentMonth;
use BrenoRoosevelt\Validation\Rules\DateTime\IsFuture;
use BrenoRoosevelt\Validation\Rules\DateTime\IsPast;
use BrenoRoosevelt\Validation\RuleSet;
use BrenoRoosevelt\Validation\Rule;

trait DateTimeFactory
{
    abstract public function add(Rule|RuleSet ...$rules): static;

    public function isPast(?string $message = null): static
    {
        return $this->add(new IsPast($message));
    }

    public function isFuture(?string $message = null): static
    {
        return $this->add(new IsFuture($message));
    }

    public function currentDay(?string $message = null): static
    {
        return $this->add(new CurrentDay($message));
    }

    public function currentMonth(bool $sameYear = true, ?string $message = null): static
    {
        return $this->add(new CurrentMonth($sameYear, $message));
    }

    public function currentYear(?string $message = null): static
    {
        return $this->add(new CurrentDay($message));
    }
}
