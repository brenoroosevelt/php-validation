<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\Guard;
use BrenoRoosevelt\Validation\Exception\ValidationExceptionInterface;
use BrenoRoosevelt\Validation\Rules\Required;
use ReflectionClass;
use ReflectionException;

final class Validator
{
    use Guard;

    /** @var RuleSet[] */
    private array $ruleSets;

    public static function new(): self
    {
        return new self;
    }

    /**
     * Returns an instance of RuleSet (immutable) or null if not set
     * @param string $field
     * @return RuleSet|null
     */
    public function ruleSet(string $field): ?RuleSet
    {
        return $this->ruleSets[$field] ?? null;
    }

    /**
     * Apply new rules to the field
     * @param string $field
     * @param Rule|RuleSet ...$rules
     * @return $this
     */
    public function field(string $field, Rule|RuleSet ...$rules): self
    {
        $ruleSet = $this->ruleSets[$field] ?? RuleSet::of($field);
        $this->ruleSets[$field] = $ruleSet->add(...$rules);
        return $this;
    }

    public function isRequired(string $field): bool
    {
        $ruleSet = $this->ruleSets[$field] ?? new RuleSet;
        foreach ($ruleSet->rules() as $rule) {
            if ($rule instanceof Required) {
                return true;
            }
        }

        return false;
    }

    public function validate(array $data = []): ValidationResultSet
    {
        $resultSet = new ValidationResultSet;
        foreach ($this->ruleSets as $field => $fieldRuleSet) {
            $fieldIsPresent = array_key_exists($field, $data);
            if (!$this->isRequired($field) && !$fieldIsPresent) {
                return new ValidationResultSet;
            }

            $result = $fieldRuleSet->validate($data[$field] ?? null, $data);
            if (!$result->isOk()) {
                $resultSet = $resultSet->add($result);
            }
        }

        return $resultSet;
    }

    /**
     * @throws ValidationExceptionInterface
     */
    public function validateOrFail(
        array $data = [],
        ValidationExceptionInterface | string | null  $validationException = null
    ): void {
        $this->validate($data)->guard($validationException);
    }

    public static function validateObject(object $object): ValidationResultSet
    {
        $data = [];
        $class = new ReflectionClass($object);
        foreach ($class->getProperties() as $property) {
            $data[$property->getName()] = $property->getValue($object);
        }

        $result = Validator::fromProperties($object)->validate($data);

        foreach ($class->getMethods() as $method) {
            $ruleSet = RuleSetFactory::fromReflectionMethod($method);
            $value = $method->invoke($method->isStatic() ? null : $object);
            $methodResult = $ruleSet->validate($value);
            if (!$methodResult->isOk()) {
                $result = $result->add($methodResult);
            }
        }

        return $result;
    }

    /**
     * @param string|object $objectOrClass
     * @param int|null $filter filter properties, ex: ReflectionProperty::IS_PUBLIC|ReflectionProperty::IS_PRIVATE
     * @return static
     * @throws ReflectionException if the class does not exist
     */
    public static function fromProperties(string|object $objectOrClass, ?int $filter = null): self
    {
        $instance = new self;
        $instance->ruleSets = RuleSetFactory::fromProperties($objectOrClass, $filter);
        return $instance;
    }
}
