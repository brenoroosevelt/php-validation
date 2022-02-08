<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Rules\NotEmpty;

trait MaybeBelongsToField
{
    private ?string $field = null;

    public function getField(): ?string
    {
        return $this->field;
    }

    public function withField(?string $field): static
    {
        if ($field !== null) {
            (new NotEmpty('When provided, the field cannot be left blank'))->validateOrFail($field);
        }

        $instance = clone $this;
        $instance->field = $field;
        return $instance;
    }

    public function belongsToField(): bool
    {
        return $this->field !== null;
    }

    private function newEmptyValidationResult(): ValidationResult|ValidationResultByField
    {
        return
            $this->belongsToField() ?
                new ValidationResultByField($this->getField()) :
                ValidationResult::everythingIsOk();
    }
}
