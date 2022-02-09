<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

class ValidationResultByField extends ValidationResult implements ResultByField
{
    private string $field;

    /**
     * @throws ValidationException
     */
    public function __construct(string $field)
    {
        RuleSet::new()->notEmptyString('The field cannot be left blank')->validateOrFail($field);
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
