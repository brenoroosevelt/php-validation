<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

class ValidationResult implements Result
{
    /** @var string[] */
    private array $errors = [];

    public static function everythingIsOk(): self
    {
        return new self;
    }

    public static function withErrors(string ...$error): self
    {
        $instance = new self;
        $instance->errors = $error;
        return $instance;
    }

    public function error(string ...$errors): self
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
}
