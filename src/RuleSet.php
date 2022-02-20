<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Contracts\Fieldable;
use BrenoRoosevelt\Validation\Contracts\Prioritable;
use BrenoRoosevelt\Validation\Contracts\Result;
use BrenoRoosevelt\Validation\Contracts\Rule;
use BrenoRoosevelt\Validation\Contracts\Stoppable;
use BrenoRoosevelt\Validation\Exception\ValidateOrFail;
use BrenoRoosevelt\Validation\Rules\AllowEmpty;
use BrenoRoosevelt\Validation\Rules\AllowNull;
use BrenoRoosevelt\Validation\Rules\IsEmpty;

class RuleSet implements Rule, Fieldable, Prioritable
{
    use RuleChain, BelongsToField, ValidateOrFail;

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
    public function validate(mixed $input, array $context = []): ErrorReporting
    {
        if (! $this->shouldValidate($input)) {
            return ErrorReporting::success();
        }

        Priority::sortByPriority($this->rules);
        $errorReporting = new ErrorReporting;
        foreach ($this->rules as $rule) {
            if ($rule instanceof Fieldable) {
                $rule = $rule->setField($this->getField());
            }

            $result = $rule->validate($input, $context);
            $errorReporting = $errorReporting->add($result);
            $stopSign = $this->stopSign($rule, $result);
            if ($stopSign !== StopSign::DONT_STOP) {
                return $errorReporting->withStopSign($stopSign);
            }
        }

        return $errorReporting;
    }

    private function stopSign(Rule $rule, Result $result): int
    {
        if (! $rule instanceof Stoppable) {
            return StopSign::DONT_STOP;
        }

        $stopWhen = [StopSign::SAME_FIELD, StopSign::ALL];
        if (!$result->isOk() && in_array($rule->stopOnFailure(), $stopWhen)) {
            return $rule->stopOnFailure();
        }

        return StopSign::DONT_STOP;
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

    public function containsRuleType(string $ruleClassName): bool
    {
        foreach ($this->rules as $rule) {
            if (is_a($rule, $ruleClassName, true)) {
                return true;
            }
        }

        return false;
    }

    public function isEmpty(): bool
    {
        return [] === $this->rules;
    }

    /** @return Rule[] */
    public function rules(): array
    {
        return $this->rules;
    }

    public function getPriority(): int
    {
        $priority = 0;
        foreach ($this->rules as $rule) {
            if ($rule instanceof Prioritable && $rule->getPriority() > $priority) {
                $priority = $rule->getPriority();
            }
        }

        return $priority;
    }
}
