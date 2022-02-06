<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

class ValidationResultByField extends ValidationResult implements ResultByField
{
    private string $field;

    public function __construct(string $field)
    {
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
