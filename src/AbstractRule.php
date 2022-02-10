<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\ValidateOrFail;

abstract class AbstractRule implements Rule
{
    use ValidateOrFail,
        BelongsToField;

    protected string $message;

    public function __construct(?string $message = null)
    {
        $this->message = $message ?? sprintf('Constraint violation: %s', $this->classShortName());
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $input, array $context = []): Result
    {
        $result = $this->newEmptyResult();
        return $this->isValid($input, $context) ? $result : $result->addError($this->message);
    }

    private function classShortName(): string
    {
        return array_reverse(explode('\\', get_class($this)))[0];
    }

    abstract public function isValid(mixed $input, array $context = []): bool;
}
