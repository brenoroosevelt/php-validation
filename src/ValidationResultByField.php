<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Rules\NotBlank;

class ValidationResultByField extends ValidationResult implements ResultByField
{
    private string $field;

    public function __construct(string $field)
    {
        (new NotBlank('The field cannot be left blank'))->validateOrFail($field);
        $this->field = $field;
    }

    /**
     * @inheritDoc
     */
    public function getField(): string
    {
        return $this->field;
    }
}
