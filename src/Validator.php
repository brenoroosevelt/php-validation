<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Rules\NotRequired;
use InvalidArgumentException;
use ReflectionException;

final class Validator
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

    public function validate(array $data): ValidationResultSet
    {
        $validationResultSet = new ValidationResultSet();
        foreach ($this->ruleSets as $ruleSet) {
            $field = $ruleSet->getField();
            if ($ruleSet->hasNotRequired() && !array_key_exists($field, $data)) {
                continue;
            }

            $result = $ruleSet->validate($data[$field] ?? null, $data);
            if (!$result->isOk()) {
                $validationResultSet->add($result);
            }
        }

        return $validationResultSet;
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
