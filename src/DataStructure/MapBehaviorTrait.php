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

    public function set(string|int $index, mixed $value): self
    {
        $this->insert($value, $index);
        return $this;
    }
}
