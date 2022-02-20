<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Contracts;

interface Prioritable extends Rule
{
    /**
     * The lowest priority
     */
    const LOWEST_PRIORITY = 0;

    /**
     * @return int
     */
    public function getPriority(): int;
}
