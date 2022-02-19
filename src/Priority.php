<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

interface Priority extends Rule
{
    /**
     * @return int
     */
    public function getPriority(): int;
}
