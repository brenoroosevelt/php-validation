<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\ValidateOrFail;
use BrenoRoosevelt\Validation\Rules\AllowsEmpty;
use BrenoRoosevelt\Validation\Rules\AllowsNull;
use BrenoRoosevelt\Validation\Rules\IsEmpty;
use BrenoRoosevelt\Validation\Rules\NotRequired;
use SplObjectStorage;

class RuleSet implements Rule
{
    use RuleChain,
        ValidateOrFail,
        MaybeBelongsToField;

    private SplObjectStorage $rules;

    final public function __construct(?string $field = null, Rule | RuleSet ...$rules)
    {
        $this->rules = new SplObjectStorage;
        $this->setField($field);
        $this->attachRules(...$rules);
    }

    public static function new(): self
    {
        return new self;
    }

    public static function of(string $field, Rule|RuleSet ...$rules): self
    {
        return new self($field, ...$rules);
    }

    public static function withRules(Rule|RuleSet ...$rules): self
    {
        return new self(null, ...$rules);
    }

    private function attachRules(Rule | RuleSet ...$rules): void
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

    public function add(Rule | RuleSet ...$rules): static
    {
        $instance = clone $this;
        $instance->attachRules(...$rules);
        return $instance;
    }

    public function validate(mixed $input, array $context = []): ValidationResult
    {
        $violations = $empty = $this->newEmptyResult();
        if (!$this->shouldValidate($input)) {
            return $empty;
        }

        foreach ($this->rules as $rule) {
            $violations = $violations->addError(...$rule->validate($input, $context)->getErrors());
        }

        return $violations;
    }

    private function shouldValidate(mixed $input): bool
    {
        if (null === $input && $this->isAllowsNull()) {
            return false;
        }

        $isEmptyInput = (new IsEmpty)->isValid($input);
        if ($isEmptyInput && $this->isAllowsEmpty()) {
            return false;
        }

        return true;
    }

    public function hasRule(string $ruleClass): bool
    {
        if (!class_exists($ruleClass)) {
            return false;
        }

        foreach ($this->rules as $rule) {
            if ($rule instanceof $ruleClass) {
                return true;
            }
        }

        return false;
    }

    public function isNotRequired(): bool
    {
        return $this->hasRule(NotRequired::class);
    }

    public function isAllowsEmpty(): bool
    {
        return $this->isEmpty() || $this->hasRule(AllowsEmpty::class);
    }

    public function isAllowsNull(): bool
    {
        return $this->isEmpty() || $this->hasRule(AllowsNull::class);
    }

    public function isEmpty(): bool
    {
        return $this->rules->count() === 0;
    }

    /** @return Rule[] */
    public function rules(): array
    {
        return iterator_to_array($this->rules);
    }
}
