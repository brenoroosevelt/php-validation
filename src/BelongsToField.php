<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

trait BelongsToField
{
    private ?string $field = null;

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(?string $field = null): static
    {
        $instance = clone $this;
        $instance->field = $field;
        return $instance;
    }

    public function belongsToField(): bool
    {
        return null !== $this->field;
    }
}
