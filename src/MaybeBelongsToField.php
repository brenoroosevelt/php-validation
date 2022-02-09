<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

trait MaybeBelongsToField
{
    private ?string $field = null;

    public function getField(): ?string
    {
        return $this->field;
    }

    public function field(?string $field): static
    {
        $instance = clone $this;
        $instance->setField($field);
        return $instance;
    }

    private function setField(?string $field): void
    {
        $this->field = $field;
    }

    public function belongsToField(): bool
    {
        return $this->field !== null;
    }

    private function newEmptyResult(): ValidationResult
    {
        return $this->belongsToField() ? ValidationResult::of($this->getField()) : ValidationResult::ok();
    }
}
