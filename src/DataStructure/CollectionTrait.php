<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\DataStructure;

trait CollectionTrait
{
    protected array $elements = [];

    public function get(string|int $index, $default = null): mixed
    {
        return $this->elements[$index] ?? $default;
    }

    protected function insert(mixed $value, $key = null): void
    {
        if ($key !== null) {
            $this->elements[$key] = $value;
        } else {
            $this->elements[] = $value;
        }
    }

    public function deleteElement(mixed $element): bool
    {
        $index = $this->indexOf($element);
        if ($index === false) {
            return false;
        }

        unset($this->elements[$index]);
        return true;
    }

    public function deleteByIndex($index): bool
    {
        if (!array_key_exists($index, $this->elements)) {
            return false;
        }

        unset($this->elements[$index]);
        return true;
    }

    public function indexOf(mixed $element): bool|int|string
    {
        return array_search($element, $this->elements, true);
    }

    public function hasIndex($index): bool
    {
        return array_key_exists($index, $this->elements);
    }

    public function hasElement(mixed $element): bool
    {
        return $this->indexOf($element) !== false;
    }

    public function clear(): static
    {
        $this->elements = [];
        return $this;
    }

    public function values(): array
    {
        return array_values($this->elements);
    }

    public function keys(): array
    {
        return array_keys($this->elements);
    }

    public function accept(callable $callback): static
    {
        foreach ($this->elements as $index => $element) {
            if (true !== call_user_func_array($callback, [$element, $index])) {
                unset($this->elements[$index]);
            }
        }

        return $this;
    }

    public function reject(callable $callback): static
    {
        foreach ($this->elements as $index => $element) {
            if (true === call_user_func_array($callback, [$element, $index])) {
                unset($this->elements[$index]);
            }
        }

        return $this;
    }

    public function forEach(callable $callback, bool $stopable = false): static
    {
        foreach ($this->elements as $index => $element) {
            $result = call_user_func_array($callback, [$element, $index]);
            if ($result === false && $stopable) {
                break;
            }
        }

        return $this;
    }

    public function length(): int
    {
        return count($this->elements);
    }

    public function isEmpty(): bool
    {
        return $this->length() === 0;
    }

    public function entries(): array
    {
        return $this->elements;
    }
}
