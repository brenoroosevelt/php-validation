<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Contracts;

interface Prioritable extends Rule
{
    /**
     * @return int
     */
    public function getPriority(): int;
}
