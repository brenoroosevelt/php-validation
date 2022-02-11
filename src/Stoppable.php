<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

interface Stoppable extends Rule
{
    /**
     * @return int Accepted values: StopSign::DONT_STOP, StopSign::SAME_FIELD, StopSign::ALL
     */
    public function stopOnFailure(): int;
}
