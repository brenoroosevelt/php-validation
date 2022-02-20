<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Contracts\Prioritable;

trait Priority
{
    protected int $priority = Prioritable::LOWEST_PRIORITY;

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $instance = clone $this;
        $instance->priority = $priority;
        return $instance;
    }

    public static function sortByPriority(array &$haystack): void
    {
        uasort($haystack, function ($a, $b) {
            $prorityOfA = $a instanceof Prioritable ? $a->getPriority() : 0;
            $prorityOfB = $b instanceof Prioritable ? $b->getPriority() : 0;

            return $prorityOfA <=> $prorityOfB;
        });
    }
}
