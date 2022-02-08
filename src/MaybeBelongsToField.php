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

    /**
     * @throws ValidationException
     */
    public function setField(?string $field): static
    {
        if ($field !== null) {
            (new NotEmpty('When provided, the field cannot be left blank'))->validateOrFail($field);
        }

        $this->field = $field;
        return $this;
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
