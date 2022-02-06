<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Rules\NotRequired;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * Composite
 */
final class ValidationSet implements Validation
{
    use Guard,
        BelongsToField;

    /** @var Validation[] */
    private array $rules;

    public static function new(): self
    {
        return new self;
    }

    public function add(Validation ...$rules): self
    {
        array_push($this->rules, ...$rules);
        return $this;
    }

    public function validate($input, array $context = []): ValidationResult|ValidationResultByField
    {
        $violations = $this->newEmptyValidationResult();
        foreach ($this->rules as $constraint) {
            $violations->add(...$constraint->validate($input, $context)->getErrors());
        }

        return $violations;
    }

    public function isRequired(): bool
    {
        foreach ($this->rules as $rule) {
            if ($rule instanceof NotRequired) {
                return false;
            }
        }

        return true;
    }

    public function notRequired(): self
    {
        if ($this->isRequired()) {
            $this->rules[] = new NotRequired;
        }

        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->rules);
    }

    /**
     * @param string|object $objectOrClass
     * @return array
     * @throws ReflectionException
     */
    public static function fromProperties(string|object $objectOrClass): array
    {
        $ruleSets = [];
        foreach ((new ReflectionClass($objectOrClass))->getProperties() as $property) {
            $ruleSets[$property->getName()] = ValidationSet::fromReflectionProperty($property);
        }

        return array_filter($ruleSets, fn(ValidationSet $c) => !$c->isEmpty());
    }

    /**
     * @param string|object $objectOrClass
     * @param string $property
     * @return static
     * @throws ReflectionException
     */
    public static function fromProperty(string|object $objectOrClass, string $property): self
    {
        return self::fromReflectionProperty(new ReflectionProperty($objectOrClass, $property));
    }

    /**
     * @param ReflectionProperty $property
     * @return static
     */
    public static function fromReflectionProperty(ReflectionProperty $property): self
    {
        $ruleSet = new self;
        $ruleSet->rules = array_map(
            fn(ReflectionAttribute $attribute) => $attribute->newInstance(),
            $property->getAttributes(Validation::class, ReflectionAttribute::IS_INSTANCEOF)
        );
        $ruleSet->setField($property->getName());
        return $ruleSet;
    }

    /** @return Validation[] */
    public function rules(): array
    {
        return $this->rules;
    }
}
