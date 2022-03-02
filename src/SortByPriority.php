<?php

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Contracts\Prioritable;

trait SortByPriority
{
    protected static function sortByPriority(array &$haystack): void
    {
        uasort($haystack, function ($a, $b) {
            $prorityOfA = $a instanceof Prioritable ? $a->getPriority() : Prioritable::LOWEST_PRIORITY;
            $prorityOfB = $b instanceof Prioritable ? $b->getPriority() : Prioritable::LOWEST_PRIORITY;

            return $prorityOfA <=> $prorityOfB;
        });
    }
}
