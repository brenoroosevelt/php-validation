<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

trait StopableTrait
{
    private bool $stopOnFailure = false;

    public function setStopOnFailure(bool $stop): static
    {
        $instance = clone $this;
        $instance->stopOnFailure = $stop;
        return $instance;
    }

    public function stopOnFailure(): bool
    {
        return $this->stopOnFailure;
    }
}
