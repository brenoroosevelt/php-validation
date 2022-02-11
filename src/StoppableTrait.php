<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

trait StoppableTrait
{
    private int $stopOnFailure = StopSign::DONT_STOP;

    public function setStopOnFailure(int $stopSign): static
    {
        $instance = clone $this;
        $instance->stopOnFailure = $stopSign;
        return $instance;
    }

    public function stopOnFailure(): int
    {
        return $this->stopOnFailure;
    }
}
