<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\DataStructure;

use Exception;

trait ArrayAccessTrait
{
    use CollectionTrait;

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->elements);
    }

    public function offsetGet(mixed $offset): mixed
    {
        if (!array_key_exists($offset, $this->elements)) {
            throw new Exception(sprintf('Undefined offset: %s', $offset));
        }

        return $this->elements[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->elements[] = $value;
        } else {
            $this->elements[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->elements[$offset]);
    }
}
