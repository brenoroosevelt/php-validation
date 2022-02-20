<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Rules\Choice;
use InvalidArgumentException;

trait StopOnFailure
{
    protected int $stopOnFailure = StopSign::DONT_STOP;

    public function setStopOnFailure(int $stopSign): static
    {
        if (! in_array($stopSign, StopSign::allowed())) {
            throw new InvalidArgumentException(sprintf('Invalid stop sign (%s)', $stopSign));
        }

        $instance = clone $this;
        $instance->stopOnFailure = $stopSign;
        return $instance;
    }

    public function stopOnFailure(): int
    {
        return $this->stopOnFailure;
    }
}
