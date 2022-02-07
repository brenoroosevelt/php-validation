<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Rules\NotEmpty;
use BrenoRoosevelt\Validation\Rules\NotRequired;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * Composite
 */
class ValidationSet implements Validation
{
    use GuardForValidation,
        MaybeBelongsToField;

    /** @var Validation[] */
    private array $rules;

    final public function __construct(?string $field = null, Validation ...$rules)
    {
        $this->field = $field;
        $this->rules = $rules;
    }

    public static function empty(): self
    {
        return new self;
    }

    /** @throws ValidationException */
    public static function forField(string $field, Validation ...$rules): self
    {
        (new NotEmpty('Field cannot be left empty'))->validateOrFail($field);
        return new self($field, ...$rules);
    }

    public static function withRules(Validation $validation, Validation ...$rules): self
    {
        return new self(null, $validation, ...$rules);
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
            $violations->error(...$constraint->validate($input, $context)->getErrors());
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
     * @param int|null $filter filter properties, ex: ReflectionProperty::IS_PUBLIC|ReflectionProperty::IS_PRIVATE
     * @return array
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
     * @param string $property
     * @return static
     * @throws ReflectionException if the class or property does not exist.
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
