<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

trait BelongsToFieldTrait
{
    private ?string $field = null;

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(?string $field): self
    {
        $this->field = $field;
        return $this;
    }

    public function belongsToField(): bool
    {
        return $this->field !== null;
    }

    private function newEmptyValidationResult(): ValidationResult|ValidationResultByField
    {
        return $this->belongsToField() ? new ValidationResultByField($this->getField()) : new ValidationResult;
    }
}
