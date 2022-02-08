<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Rules\NotEmptyString;

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
    public function field(?string $field): static
    {
        $instance = clone $this;
        $instance->setField($field);
        return $instance;
    }

    /**
     * @throws ValidationException
     */
    private function setField(?string $field): void
    {
        (new NotEmptyString('When provided, the field cannot be left blank'))->validateOrFail($field);
        $this->field = $field;
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
