<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\DataStructure;

use Countable;
use IteratorAggregate;

class Set implements IteratorAggregate, Countable
{
    use SetBehaviorTrait,
        IteratorTrait,
        CountableTrait;
}
