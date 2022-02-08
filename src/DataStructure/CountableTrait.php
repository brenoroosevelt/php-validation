<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\DataStructure;

trait CountableTrait
{
    use CollectionTrait;

    public function count(): int
    {
        return count($this->elements);
    }
}
