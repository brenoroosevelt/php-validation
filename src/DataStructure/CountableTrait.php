<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\DataStructure;

trait CountableTrait
{
    abstract protected function entries(): array;

    public function count(): int
    {
        return count($this->entries());
    }
}
