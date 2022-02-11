<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\ValidateOrFailTrait;
use BrenoRoosevelt\Validation\Rules\AllowEmpty;
use BrenoRoosevelt\Validation\Rules\AllowNull;
use BrenoRoosevelt\Validation\Rules\IsEmpty;
use BrenoRoosevelt\Validation\Rules\Required;

class RuleSet implements Rule, BelongsToField, Stopable
{
    use RuleChainTrait, BelongsToFieldTrait, StopableTrait, ValidateOrFailTrait;

    /** @var Rule[] */
    private array $rules = [];

    final public function __construct(?string $field = null, Rule | RuleSet ...$rules)
    {
        $this->field = $field;
        foreach ($rules as $ruleOrRuleSet) {
            array_push(
                $this->rules,
                ...($ruleOrRuleSet instanceof RuleSet ? $ruleOrRuleSet->rules() : [$ruleOrRuleSet])
            );
        }
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
        return new self($this->field, ...$this->rules, ...$rules);
    }

    /** @inheritDoc */
    public function validate(mixed $input, array $context = []): Result
    {
        if (!$this->shouldValidate($input, $context)) {
            return ErrorReporting::success();
        }

        $errorReporting = new ErrorReporting;
        foreach ($this->rules as $rule) {
            if ($rule instanceof BelongsToField) {
                $rule = $rule->setField($this->getField());
            }

            $result = $rule->validate($input, $context);
            $errorReporting = $errorReporting->add($result);
            if ($this->shouldStop($rule, $result)) {
                $this->stopOnFailure = true;
                break;
            }
        }

        return $errorReporting;
    }

    private function shouldValidate(mixed $input): bool
    {
        if (null === $input && $this->containsRuleType(AllowNull::class)) {
            return false;
        }

        if ((new IsEmpty)->isValid($input) && $this->containsRuleType(AllowEmpty::class)) {
            return false;
        }

        return true;
    }

    private function shouldStop(Rule $rule, Result $result): bool
    {
        return $rule instanceof Stopable && $rule->stopOnFailure() && !$result->isOk();
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

    public function containsRuleType(string $ruleClassName): bool
    {
        foreach ($this->rules as $rule) {
            if (is_a($rule, $ruleClassName, true)) {
                return true;
            }
        }

        return false;
    }
}
