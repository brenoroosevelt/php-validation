<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Exception\GuardTrait;
use BrenoRoosevelt\Validation\Exception\ValidationExceptionFactoryInterface;
use BrenoRoosevelt\Validation\Exception\ValidationExceptionInterface;
use ReflectionClass;
use ReflectionException;

final class Validator
{
    use GuardTrait;

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

    public function validate(array $data = []): ErrorReporting
    {
        $errorReporting = new ErrorReporting;
        foreach ($this->ruleSets as $field => $fieldRuleSet) {
            $fieldIsPresent = array_key_exists($field, $data);
            if (!$fieldRuleSet->hasRequired() && !$fieldIsPresent) {
                continue;
            }

            $fieldRuleSet = $fieldRuleSet->setField($field);
            $result = $fieldRuleSet->validate($data[$field] ?? null, $data);
            $errorReporting = $errorReporting->add($result);

            if ($fieldRuleSet instanceof Stopable && $fieldRuleSet->stopOnFailure() && !$result->isOk()) {
                break;
            }
        }

        return $errorReporting;
    }

    /** @throws ValidationExceptionInterface */
    public function validateOrFail(
        array $data = [],
        ValidationExceptionFactoryInterface | ValidationExceptionInterface | string | null  $validationException = null
    ): void {
        $this->validate($data)->guard($validationException);
    }

    public static function validateObject(object $object): ErrorReporting
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
