<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\DataStructure;

trait SetBehaviorTrait
{
    use CollectionTrait;

    public function __construct(iterable $elements = [])
    {
        foreach ($elements as $element) {
            $this->add($element);
        }
    }

    public function add(mixed ...$elements): self
    {
        foreach ($elements as $element) {
            if (!$this->hasElement($element)) {
                $this->elements[] = $element;
            }
        }

        return $this;
    }
}
