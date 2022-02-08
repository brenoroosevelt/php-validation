<?php

namespace BrenoRoosevelt\Validation;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

final class RuleSetFactory
{
    /**
     * @param string|object $objectOrClass
     * @param int|null $filter filter properties, ex: ReflectionProperty::IS_PUBLIC|ReflectionProperty::IS_PRIVATE
     * @return RuleSet[]
     * @throws ReflectionException if the class does not exist
     */
    public static function fromProperties(string|object $objectOrClass, ?int $filter = null): array
    {
        $ruleSets = [];
        foreach ((new ReflectionClass($objectOrClass))->getProperties($filter) as $property) {
            $ruleSets[$property->getName()] = self::fromReflectionProperty($property);
        }

        return array_filter($ruleSets, fn(RuleSet $c) => !$c->isEmpty());
    }

    /**
     * @param string|object $objectOrClass
     * @param int|null $filter
     * @return RuleSet[]
     * @throws ReflectionException
     */
    public static function fromMethods(string|object $objectOrClass, ?int $filter = null): array
    {
        $ruleSets = [];
        foreach ((new ReflectionClass($objectOrClass))->getMethods($filter) as $method) {
            $ruleSets[$method->getName()] = self::fromReflectionMethod($method);
        }

        return array_filter($ruleSets, fn(RuleSet $c) => !$c->isEmpty());
    }

    /**
     * @param string|object $objectOrClass
     * @param string $property
     * @return RuleSet
     * @throws ReflectionException if the class or property does not exist.
     */
    public static function fromProperty(string|object $objectOrClass, string $property): RuleSet
    {
        return self::fromReflectionProperty(new ReflectionProperty($objectOrClass, $property));
    }

    /**
     * @param string|object $objectOrClass
     * @param string $method
     * @return RuleSet
     * @throws ReflectionException
     */
    public static function fromMethod(string|object $objectOrClass, string $method): RuleSet
    {
        return self::fromReflectionMethod(new ReflectionMethod($objectOrClass, $method));
    }

    /**
     * @param ReflectionProperty $property
     * @return RuleSet
     */
    public static function fromReflectionProperty(ReflectionProperty $property): RuleSet
    {
        return
            RuleSet::forField(
                $property->getName(),
                ...array_map(
                    fn(ReflectionAttribute $attribute) => $attribute->newInstance(),
                    $property->getAttributes(Rule::class, ReflectionAttribute::IS_INSTANCEOF)
                )
            );
    }

    /**
     * @param ReflectionMethod $method
     * @return RuleSet
     */
    public static function fromReflectionMethod(ReflectionMethod $method): RuleSet
    {
        return
            RuleSet::withRules(
                ...array_map(
                    fn(ReflectionAttribute $attribute) => $attribute->newInstance(),
                    $method->getAttributes(Rule::class, ReflectionAttribute::IS_INSTANCEOF)
                )
            );
    }
}
