<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\ValidateOrFail;
use BrenoRoosevelt\Validation\Rules\AllowsNull;

class RuleSet implements Rule
{
    use RuleChain,
        ValidateOrFail,
        BelongsToField;

    private array $rules = [];

    final public function __construct(?string $field = null, Rule | RuleSet ...$rules)
    {
        $this->attachRules(...$rules);
        $this->setField($field);
    }

    public static function new(): self
    {
        return new self;
    }

    public static function of(string $field, Rule | RuleSet ...$rules): self
    {
        return new self($field, ...$rules);
    }

    public static function withRules(Rule | RuleSet ...$rules): self
    {
        return new self(null, ...$rules);
    }

    public function add(Rule | RuleSet ...$rules): static
    {
        $instance = clone $this;
        $instance->attachRules(...$rules);
        return $instance;
    }

    private function attachRules(Rule | RuleSet ...$rules): void
    {
        foreach ($rules as $ruleOrRuleSet) {
            array_push(
                $this->rules,
                ...($ruleOrRuleSet instanceof Rule ? [$ruleOrRuleSet] : $ruleOrRuleSet->rules())
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $input, array $context = []): ValidationResult
    {
        $result = $this->newEmptyResult();
        foreach ($this->rules as $rule) {
            if (null == $input && $this->isAllowsNull()) {
                return $this->newEmptyResult();
            }

            $result = $result->addError(...$rule->validate($input, $context)->getErrors());
        }

        return $result;
    }

    public function isAllowsNull(): bool
    {
        foreach ($this->rules as $rule) {
            if ($rule instanceof AllowsNull) {
                return true;
            }
        }

        return false;
    }

    public function isEmpty(): bool
    {
        return empty($this->rules);
    }

    /** @return Rule[] */
    public function rules(): array
    {
        return $this->rules;
    }
}
