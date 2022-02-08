<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\DataStructure;

use ArrayIterator;

trait IteratorTrait
{
    use CollectionTrait;

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->elements);
    }
}
