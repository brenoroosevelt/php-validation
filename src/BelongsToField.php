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

    public function withField(?string $field = null): static
    {
        $instance = clone $this;
        $instance->setField($field);
        return $instance;
    }

    protected function setField(?string $field): void
    {
        $this->field = $field;
    }

    public function belongsToField(): bool
    {
        return null !== $this->field;
    }
}
