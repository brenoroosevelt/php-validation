<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Contracts\Stoppable;
use InvalidArgumentException;

trait StopOnFailure
{
    private int $stopOnFailure;

    public function withStopSign(int $stopSign): static
    {
        $instance = clone $this;
        $instance->setStopSign($stopSign);
        return $instance;
    }

    protected function setStopSign(int $stopSign): void
    {
        if (! in_array($stopSign, [Stoppable::DONT_STOP, Stoppable::ALL, Stoppable::SAME_FIELD])) {
            throw new InvalidArgumentException(sprintf('Invalid stop sign (%s)', $stopSign));
        }

        $this->stopOnFailure = $stopSign;
    }

    public function stopOnFailure(): int
    {
        return $this->stopOnFailure;
    }
}
