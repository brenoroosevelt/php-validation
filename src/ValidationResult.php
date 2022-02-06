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

    public function add(string ...$errors): self
    {
        array_push($this->errors, ...$errors);
        return $this;
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
