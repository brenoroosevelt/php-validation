<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use ReflectionClass;
use ReflectionException;

final class Validator
{
    /** @var RuleSet[] */
    private array $ruleSets;

    public static function new(): self
    {
        return new self;
    }

    public function ruleSet(string $field, Rule|RuleSet ...$rules): RuleSet
    {
        $ruleSet = $this->ruleSets[$field] ?? $this->ruleSets[$field] = RuleSet::forField($field);
        return $ruleSet->add(...$rules);
    }

    public function validate(array $data = []): ValidationResultSet
    {
        $validationResultSet = new ValidationResultSet;
        foreach ($this->ruleSets as $field => $fieldRuleSet) {
            if (!$fieldRuleSet->isRequired() && !array_key_exists($field, $data)) {
                continue;
            }

            $result = $fieldRuleSet->validate($data[$field] ?? null, $data);
            if (!$result->isOk()) {
                $validationResultSet = $validationResultSet->add($result);
            }
        }

        return $validationResultSet;
    }

    public function only(string ...$fields): self
    {
        $instance = clone $this;
        $instance->ruleSets =
            array_filter($instance->ruleSets, fn(RuleSet $ruleSet) => in_array($ruleSet->getField(), $fields));
        return $instance;
    }

    public function except(string ...$fields): self
    {
        $instance = clone $this;
        $instance->ruleSets =
            array_filter($instance->ruleSets, fn(RuleSet $ruleSet) => !in_array($ruleSet->getField(), $fields));
        return $instance;
    }

    /**
     * @throws ReflectionException
     */
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
     * @param array $data
     * @param ?string $message
     * @return void
     * @throws ValidationException
     */
    public function validateOrFail(array $data = [], ?string $message = null)
    {
        $result = $this->validate($data);
        if (!$result->isOk()) {
            throw new ValidationException($result, $message);
        }
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
