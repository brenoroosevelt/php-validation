<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Contracts;

interface Stoppable extends Rule
{
    const DONT_STOP = 0;
    const SAME_FIELD = 1;
    const ALL = 2;

    /**
     * @return int A constant of this interface
     */
    public function stopOnFailure(): int;
}
