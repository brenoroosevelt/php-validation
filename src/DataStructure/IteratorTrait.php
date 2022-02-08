<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\DataStructure;

use ArrayIterator;

trait IteratorTrait
{
    abstract protected function entries(): array;

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->entries());
    }
}
