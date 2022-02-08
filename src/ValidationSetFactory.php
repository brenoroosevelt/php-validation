<?php

namespace BrenoRoosevelt\Validation;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

final class ValidationSetFactory
{
    /**
     * @param string|object $objectOrClass
     * @param int|null $filter filter properties, ex: ReflectionProperty::IS_PUBLIC|ReflectionProperty::IS_PRIVATE
     * @return ValidationSet[]
     * @throws ReflectionException if the class does not exist
     */
    public static function fromProperties(string|object $objectOrClass, ?int $filter = null): array
    {
        $ruleSets = [];
        foreach ((new ReflectionClass($objectOrClass))->getProperties($filter) as $property) {
            $ruleSets[$property->getName()] = self::fromReflectionProperty($property);
        }

        return array_filter($ruleSets, fn(ValidationSet $c) => !$c->isEmpty());
    }

    /**
     * @param string|object $objectOrClass
     * @param int|null $filter
     * @return ValidationSet[]
     * @throws ReflectionException
     */
    public static function fromMethods(string|object $objectOrClass, ?int $filter = null): array
    {
        $ruleSets = [];
        foreach ((new ReflectionClass($objectOrClass))->getMethods($filter) as $method) {
            $ruleSets[$method->getName()] = self::fromReflectionMethod($method);
        }

        return array_filter($ruleSets, fn(ValidationSet $c) => !$c->isEmpty());
    }

    /**
     * @param string|object $objectOrClass
     * @param string $property
     * @return ValidationSet
     * @throws ReflectionException if the class or property does not exist.
     */
    public static function fromProperty(string|object $objectOrClass, string $property): ValidationSet
    {
        return self::fromReflectionProperty(new ReflectionProperty($objectOrClass, $property));
    }

    /**
     * @param string|object $objectOrClass
     * @param string $method
     * @return ValidationSet
     * @throws ReflectionException
     */
    public static function fromMethod(string|object $objectOrClass, string $method): ValidationSet
    {
        return self::fromReflectionMethod(new ReflectionMethod($objectOrClass, $method));
    }

    /**
     * @param ReflectionProperty $property
     * @return ValidationSet
     */
    public static function fromReflectionProperty(ReflectionProperty $property): ValidationSet
    {
        return
            ValidationSet::forField(
                $property->getName(),
                ...array_map(
                    fn(ReflectionAttribute $attribute) => $attribute->newInstance(),
                    $property->getAttributes(Validation::class, ReflectionAttribute::IS_INSTANCEOF)
                )
            );
    }

    /**
     * @param ReflectionMethod $method
     * @return ValidationSet
     */
    public static function fromReflectionMethod(ReflectionMethod $method): ValidationSet
    {
        return
            ValidationSet::withRules(
                ...array_map(
                    fn(ReflectionAttribute $attribute) => $attribute->newInstance(),
                    $method->getAttributes(Validation::class, ReflectionAttribute::IS_INSTANCEOF)
                )
            );
    }
}
