<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

final class Validator
{
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

        return $this->ruleSets[] = ValidationSet::forField($field);
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

    public function validate(array $data = []): ValidationResultSet
    {
        $validationResultSet = new ValidationResultSet;
        foreach ($this->ruleSets as $ruleSet) {
            $field = $ruleSet->getField();
            if (!$ruleSet->isRequired() && !array_key_exists($field, $data)) {
                continue;
            }

            $result = $ruleSet->validate($data[$field] ?? null, $data);
            if (!$result->isOk()) {
                $validationResultSet = $validationResultSet->add($result);
            }
        }

        return $validationResultSet;
    }

    /**
     * @throws ReflectionException
     */
    public function validateObject(object $object): ValidationResultSet
    {
        $data = [];
        $properties = (new ReflectionClass($object))->getProperties();
        foreach ($properties as $property) {
            $data[$property->getName()] = $property->getValue($object);
        }

        $result = Validator::fromProperties($object)->validate($data);

        $methodRules = ValidationSet::fromMethods($object);
        foreach ($methodRules as $methodName => $ruleSet) {
            $value = (new ReflectionMethod($object, $methodName))->invoke($object);
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
        $instance->ruleSets = ValidationSet::fromProperties($objectOrClass, $filter);
        return $instance;
    }
}
