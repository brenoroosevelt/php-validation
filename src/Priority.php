<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Contracts\Prioritable;

trait Priority
{
    private int $priority;

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function withPriority(int $priority): static
    {
        $instance = clone $this;
        $instance->setPriority($priority);
        return $instance;
    }

    protected function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }
}
