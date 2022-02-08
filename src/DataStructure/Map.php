<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\DataStructure;

use ArrayAccess;
use Countable;
use IteratorAggregate;

class Map implements IteratorAggregate, ArrayAccess, Countable
{
    use CollectionTrait,
        MapBehaviorTrait,
        IteratorTrait,
        CountableTrait,
        ArrayAccessTrait;
}
