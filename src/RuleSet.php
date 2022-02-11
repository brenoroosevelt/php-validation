<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\ValidateOrFailTrait;
use BrenoRoosevelt\Validation\Rules\AllowEmpty;
use BrenoRoosevelt\Validation\Rules\AllowNull;
use BrenoRoosevelt\Validation\Rules\IsEmpty;

class RuleSet implements Rule, BelongsToField, Stopable
{
    use RuleChainTrait, BelongsToFieldTrait, ValidateOrFailTrait;

    /** @var Rule[] */
    private array $rules = [];

    private ErrorReporting $errorReporting;

    final public function __construct(?string $field = null, Rule | RuleSet ...$rules)
    {
        $this->errorReporting = new ErrorReporting;
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
        if (!$this->shouldValidate($input)) {
            return ErrorReporting::success();
        }

        $this->errorReporting = new ErrorReporting;
        foreach ($this->rules as $rule) {
            if ($rule instanceof BelongsToField) {
                $rule = $rule->setField($this->getField());
            }

            $result = $rule->validate($input, $context);
            $this->errorReporting = $this->errorReporting->add($result);
            if ($this->shouldStop()) {
                break;
            }
        }

        return $this->errorReporting;
    }

    public function stopOnFailure(): int
    {
        $stopSignResult = StopSign::DONT_STOP;
        foreach ($this->errorReporting->getErrors() as $error) {
            $rule = $error->rule();
            $stopSign = $rule instanceof Stopable ? $rule->stopOnFailure() : StopSign::DONT_STOP;
            if ($stopSign === StopSign::ALL) {
                return $stopSign;
            }

            if ($stopSign === StopSign::SAME_FIELD) {
                $stopSignResult = StopSign::SAME_FIELD;
            }
        }

        return $stopSignResult;
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

    private function shouldStop(): bool
    {
        return $this->stopOnFailure() !== StopSign::DONT_STOP;
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
        return empty($this->rules);
    }

    /** @return Rule[] */
    public function rules(): array
    {
        return $this->rules;
    }
}
