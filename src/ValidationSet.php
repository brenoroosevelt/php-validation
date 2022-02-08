<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Rules\AllowsEmpty;
use BrenoRoosevelt\Validation\Rules\AllowsNull;
use BrenoRoosevelt\Validation\Rules\NotRequired;
use Countable;
use IteratorAggregate;
use SplObjectStorage;

class ValidationSet implements Validation, IteratorAggregate, Countable
{
    use GuardForValidation,
        MaybeBelongsToField;

    private SplObjectStorage $rules;

    final public function __construct(?string $field = null, Validation|ValidationSet ...$rules)
    {
        $this->rules = new SplObjectStorage;
        $this->field = $field;
        $this->attachRules(...$rules);
    }

    public static function empty(): self
    {
        return new self;
    }

    public static function forField(string $field, Validation|ValidationSet ...$rules): self
    {
        return new self($field, ...$rules);
    }

    public static function withRules(Validation|ValidationSet ...$rules): self
    {
        return new self(null, ...$rules);
    }

    public function add(Validation|ValidationSet ...$rules): self
    {
        $instance = clone $this;
        $instance->attachRules(...$rules);
        return $instance;
    }

    private function attachRules(Validation|ValidationSet ...$rules): void
    {
        foreach ($rules as $validationOrSet) {
            if ($validationOrSet instanceof Validation) {
                $this->rules->attach($validationOrSet);
            }

            if ($validationOrSet instanceof ValidationSet) {
                foreach ($validationOrSet as $validation) {
                    $this->rules->attach($validation);
                }
            }
        }
    }

    public function validate(mixed $input, array $context = []): ValidationResult|ValidationResultByField
    {
        $violations = $empty = $this->newEmptyValidationResult();
        if (null === $input && $this->allowsNull()) {
            return $empty;
        }

        if (empty($input) && $this->allowsEmpty()) {
            return $empty;
        }

        foreach ($this->rules as $rule) {
            $violations = $violations->error(...$rule->validate($input, $context)->getErrors());
        }

        return $violations;
    }

    public function isRequired(): bool
    {
        if ($this->isEmpty()) {
            return false;
        }

        foreach ($this->rules as $rule) {
            if ($rule instanceof NotRequired) {
                return false;
            }
        }

        return true;
    }

    public function allowsEmpty(): bool
    {
        if ($this->isEmpty()) {
            return true;
        }

        foreach ($this->rules as $rule) {
            if ($rule instanceof AllowsEmpty) {
                return true;
            }
        }

        return false;
    }

    public function allowsNull(): bool
    {
        if ($this->isEmpty()) {
            return true;
        }

        foreach ($this->rules as $rule) {
            if ($rule instanceof AllowsNull) {
                return true;
            }
        }

        return false;
    }

    public function setNotRequired(): self
    {
        return $this->add(NotRequired::instance());
    }

    public function setAllowsEmpty(): self
    {
        return $this->add(AllowsEmpty::instance());
    }

    public function setAllowsNull(): self
    {
        return $this->add(AllowsNull::instance());
    }

    public function isEmpty(): bool
    {
        return $this->rules->count() === 0;
    }

    /** @return Validation[] */
    public function toArray(): array
    {
        return iterator_to_array($this->rules);
    }

    public function getIterator(): SplObjectStorage
    {
        return clone $this->rules;
    }

    public function count(): int
    {
        return $this->rules->count();
    }
}
