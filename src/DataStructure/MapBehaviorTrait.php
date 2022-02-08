<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\DataStructure;

trait MapBehaviorTrait
{
    use CollectionTrait;

    public function __construct(iterable $elements = [])
    {
        foreach ($elements as $index => $element) {
            $this->set($index, $element);
        }
    }

    public function set(string|int $index, $value): self
    {
        $this->insert($value, $index);
        return $this;
    }

    public function get(string|int $index, $default = null): mixed
    {
        return $this->elements[$index] ?? $default;
    }

    public function has(mixed $index): bool
    {
        return array_key_exists($index, $this->elements);
    }

    public function delete(string|int $index): bool
    {
        return $this->deleteByIndex($index);
    }

    public function hasElement(mixed $element): bool
    {
        return $this->indexOf($element) !== false;
    }
}
