<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\DataStructure;

use Countable;
use IteratorAggregate;

class Collection implements IteratorAggregate, Countable
{
    use CollectionTrait {
        insert as public;
        deleteElement as public;
        deleteByIndex as public;
    }

    use IteratorTrait,
        CountableTrait;

    public function __construct(iterable $values = [])
    {
        if (is_array($values)) {
            $this->elements = $values;
        } else {
            foreach ($values as $key => $value) {
                $this->insert($value, $key);
            }
        }
    }
}
