<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\Guard;
use BrenoRoosevelt\Validation\Exception\ValidationExceptionInterface;

class ValidationResult implements Result
{
    use Guard;

    use BelongsToField {
        getField as private _getField;
    }

    /** @var string[] */
    private array $errors = [];

    public static function ok(): self
    {
        return new self;
    }

    public static function of(string $field, string ...$errors): self
    {
        return self::withErrors(...$errors)->field($field);
    }

    public static function withErrors(string ...$error): self
    {
        $instance = new self;
        $instance->errors = $error;
        return $instance;
    }

    public function addError(string ...$errors): self
    {
        $instance = clone $this;
        array_push($instance->errors, ...$errors);
        return $instance;
    }

    /**
     * @inheritDoc
     */
    public function isOk(): bool
    {
        return empty($this->errors);
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @inheritDoc
     */
    public function getField(): ?string
    {
        return $this->_getField();
    }

    /**
     * @throws ValidationExceptionInterface
     */
    public function guard(?ValidationExceptionInterface $validationException = null): void
    {
        $this->guardResult($this, $validationException);
    }
}
