<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

trait PriorityTrait
{
    protected int $priority = 0;

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
            $prorityOfA = $a instanceof Priority ? $a->getPriority() : 0;
            $prorityOfB = $b instanceof Priority ? $b->getPriority() : 0;

            return $prorityOfA <=> $prorityOfB;
        });
    }
}
