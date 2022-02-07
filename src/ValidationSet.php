<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Rules\AllowsEmpty;
use BrenoRoosevelt\Validation\Rules\AllowsNull;
use BrenoRoosevelt\Validation\Rules\NotRequired;
use Composer\DependencyResolver\RuleSet;
use Countable;
use IteratorAggregate;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;
use SplObjectStorage;

class ValidationSet implements Validation, IteratorAggregate, Countable
{
    use GuardForValidation,
        MaybeBelongsToField;

    private SplObjectStorage $rules;

    final public function __construct(?string $field = null, Validation ...$rules)
    {
        $this->rules = new SplObjectStorage();
        $this->setField($field);
        $this->add(...$rules);
    }

    public static function empty(): self
    {
        return new self;
    }

    public static function forField(string $field, Validation ...$rules): self
    {
        return new self($field, ...$rules);
    }

    public static function withRules(Validation $validation, Validation ...$rules): self
    {
        return new self(null, $validation, ...$rules);
    }

    public function add(Validation | ValidationSet ...$rules): self
    {
        foreach ($rules as $rule) {
            if ($rule instanceof Validation) {
                $this->rules->attach($rule);
            }

            if ($rule instanceof ValidationSet) {
                $this->add(...$rule->toArray());
            }
        }

        return $this;
    }

    public function validate(mixed $input, array $context = []): ValidationResult|ValidationResultByField
    {
        $violations = $this->newEmptyValidationResult();
        if (null === $input && $this->allowsNull()) {
            return $violations;
        }

        if (empty($input) && $this->allowsEmpty()) {
            return $violations;
        }

        foreach ($this->rules as $rule) {
            $violations = $violations->error(...$rule->validate($input, $context)->getErrors());
        }

        return $violations;
    }

    public function isRequired(): bool
    {
        if ($this->isEmpty()) {
            return false;
        }

        foreach ($this->rules as $rule) {
            if ($rule instanceof NotRequired) {
                return false;
            }
        }

        return true;
    }

    public function allowsEmpty(): bool
    {
        if ($this->isEmpty()) {
            return true;
        }

        foreach ($this->rules as $rule) {
            if ($rule instanceof AllowsEmpty) {
                return true;
            }
        }

        return false;
    }

    public function allowsNull(): bool
    {
        if ($this->isEmpty()) {
            return true;
        }

        foreach ($this->rules as $rule) {
            if ($rule instanceof AllowsNull) {
                return true;
            }
        }

        return false;
    }

    public function setNotRequired(): self
    {
        return $this->add(NotRequired::instance());
    }

    public function setAllowsEmpty(): self
    {
        return $this->add(AllowsEmpty::instance());
    }

    public function setAllowsNull(): self
    {
        return $this->add(AllowsNull::instance());
    }

    public function isEmpty(): bool
    {
        return $this->rules->count() === 0;
    }

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
            $ruleSets[$property->getName()] = ValidationSet::fromReflectionProperty($property);
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
            $ruleSets[$method->getName()] = ValidationSet::fromReflectionMethod($method);
        }

        return array_filter($ruleSets, fn(ValidationSet $c) => !$c->isEmpty());
    }

    /**
     * @param string|object $objectOrClass
     * @param string $property
     * @return static
     * @throws ReflectionException if the class or property does not exist.
     */
    public static function fromProperty(string|object $objectOrClass, string $property): self
    {
        return self::fromReflectionProperty(new ReflectionProperty($objectOrClass, $property));
    }

    public static function fromMethod(string|object $objectOrClass, string $method): self
    {
        return self::fromReflectionMethod(new ReflectionMethod($objectOrClass, $method));
    }

    /**
     * @param ReflectionProperty $property
     * @return static
     */
    public static function fromReflectionProperty(ReflectionProperty $property): self
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
     * @return static
     */
    public static function fromReflectionMethod(ReflectionMethod $method): self
    {
        return
            ValidationSet::withRules(
                ...array_map(
                    fn(ReflectionAttribute $attribute) => $attribute->newInstance(),
                    $method->getAttributes(Validation::class, ReflectionAttribute::IS_INSTANCEOF)
                )
            );
    }

    /** @return Validation[] */
    public function toArray(): array
    {
        return iterator_to_array($this->rules);
    }

    public function getIterator(): SplObjectStorage
    {
        return clone $this->rules;
    }

    public function count(): int
    {
        return $this->rules->count();
    }
}
