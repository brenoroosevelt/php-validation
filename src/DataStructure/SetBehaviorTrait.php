<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\DataStructure;

trait SetBehaviorTrait
{
    use CollectionTrait;

    public function __construct(iterable $values = [])
    {
        foreach ($values as $value) {
            $this->add($value);
        }
    }

    public function add(mixed $value): self
    {
        if (!$this->has($value)) {
            $this->elements[] = $value;
        }

        return $this;
    }

    public function has(mixed $element): bool
    {
        return $this->indexOf($element) !== false;
    }

    public function delete(mixed $element): bool
    {
        return $this->deleteElement($element);
    }
}
