<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Rules\NotRequired;
use InvalidArgumentException;
use ReflectionException;

final class Validator implements Validation
{
    use GuardTrait;

    /** @var ValidationSet[] */
    private array $ruleSets;

    public static function new(): self
    {
        return new self;
    }

    public function ruleSet(string $field): ValidationSet
    {
        foreach ($this->ruleSets as $ruleSet) {
            if ($ruleSet->getField() === $field) {
                return $ruleSet;
            }
        }

        return $this->ruleSets[] = (new ValidationSet)->setField($field);
    }

    public function field(string $field, Validation|ValidationSet ...$rules): self
    {
        $ruleset = $this->ruleSet($field);
        foreach ($rules as $rule) {
            if ($rule instanceof Validation) {
                $ruleset->add($rule);
            }

            if ($rule instanceof ValidationSet) {
                $ruleset->add(...$rule->rules());
            }
        }

        return $this;
    }

    public function validate($input, array $context = []): ValidationResultSet
    {
        if (!is_array($input)) {
            throw new InvalidArgumentException('array expected');
        }

        $violationSet = new ValidationResultSet();
        foreach ($this->ruleSets as $ruleSet) {
            $field = $ruleSet->getField();
            if (!$this->isRequired($field) && !array_key_exists($field, $input)) {
                continue;
            }

            $violation = $ruleSet->validate($input[$field] ?? null, $context);
            $violationSet->add($violation);
        }

        return $violationSet;
    }

    public function isRequired(string $field): bool
    {
        $ruleSet = $this->ruleSet($field);
        if ($ruleSet->isEmpty()) {
            return false;
        }

        foreach ($ruleSet->rules() as $rule) {
            if ($rule instanceof NotRequired) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string|object $objectOrClass
     * @return static
     * @throws ReflectionException
     */
    public static function fromProperties(string|object $objectOrClass): self
    {
        $instance = new self;
        $instance->ruleSets = ValidationSet::fromProperties($objectOrClass);
        return $instance;
    }
}
