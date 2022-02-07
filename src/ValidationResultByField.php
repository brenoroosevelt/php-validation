<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Rules\NotEmpty;

class ValidationResultByField extends ValidationResult implements ResultByField
{
    private string $field;

    public function __construct(string $field)
    {
        (new NotEmpty('The field cannot be left blank'))->validateOrFail($field);
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
