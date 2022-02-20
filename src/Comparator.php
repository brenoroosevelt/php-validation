<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Translation\Translator;
use InvalidArgumentException;

trait Comparator
{
    public function compare(mixed $a, string $operator, mixed $b): bool
    {
        return
        match ($operator) {
            Operator::EQUAL => $a == $b,
            Operator::EXACTLY => $a === $b,
            Operator::GREATER_THAN => $a > $b,
            Operator::GREATER_THAN_EQUAL => $a >= $b,
            Operator::LESS_THAN => $a < $b,
            Operator::LESS_THAN_EQUAL => $a <= $b,
            Operator::NOT_EQUAL => $a != $b,
            Operator::NOT_EXACTLY => $a !== $b,
            default => throw new InvalidArgumentException(sprintf('Invalid operator: %s', $operator))
        };
    }
}
