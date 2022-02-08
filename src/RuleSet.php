<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Factories\ComparisonFactory;
use BrenoRoosevelt\Validation\Rules\AllowsEmpty;
use BrenoRoosevelt\Validation\Rules\AllowsNull;
use BrenoRoosevelt\Validation\Rules\NotRequired;
use Countable;
use IteratorAggregate;
use SplObjectStorage;

class RuleSet implements Rule, IteratorAggregate, Countable
{
    use GuardForValidation,
        ComparisonFactory,
        MaybeBelongsToField {
        setField as private;
    }

    private SplObjectStorage $rules;

    /**
     * @throws ValidationException if the field is provided and is blank
     */
    final public function __construct(?string $field = null, Rule|RuleSet ...$rules)
    {
        $this->rules = new SplObjectStorage;
        $this->field = $field;
        $this->attachRules(...$rules);
    }

    public static function new(): self
    {
        return new self;
    }

    public static function forField(string $field, Rule|RuleSet ...$rules): self
    {
        return new self($field, ...$rules);
    }

    public static function withRules(Rule|RuleSet ...$rules): self
    {
        return new self(null, ...$rules);
    }

    private function attachRules(Rule|RuleSet ...$rules): void
    {
        foreach ($rules as $validationOrSet) {
            if ($validationOrSet instanceof Rule) {
                $this->rules->attach($validationOrSet);
            }

            if ($validationOrSet instanceof RuleSet) {
                foreach ($validationOrSet as $validation) {
                    $this->rules->attach($validation);
                }
            }
        }
    }

    public function add(Rule|RuleSet ...$rules): self
    {
        $instance = clone $this;
        $instance->attachRules(...$rules);
        return $instance;
    }

    public function validate(mixed $input, array $context = []): ValidationResult|ValidationResultByField
    {
        $violations = $empty = $this->newEmptyValidationResult();
        if (null === $input && $this->allowsNull()) {
            return $empty;
        }

        if ((is_string($input) || is_array($input)) && empty($input) && $this->allowsEmpty()) {
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

    /** @return Rule[] */
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
