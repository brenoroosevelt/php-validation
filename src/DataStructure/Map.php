<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\DataStructure;

use Countable;
use IteratorAggregate;

class Map implements IteratorAggregate, Countable
{
    use MapBehaviorTrait,
        IteratorTrait,
        CountableTrait;
}
