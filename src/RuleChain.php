<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

use BrenoRoosevelt\Validation\Contracts\Rule;
use RuntimeException;

/**
 * @internal
 * @method self allowNull()
 * @method self allowEmpty()
 * @method self required(?string $message = null)
 * @method self notEmpty(?string $message = null)
 * @method self notEmptyString(?string $message = null)
 * @method self notNull(?string $message = null)
 * @method self email(?string $message = null)
 */
trait RuleChain
{
    abstract public function add(Rule|RuleSet ...$rules): static;

    public function __call($name, $arguments): static
    {
        $namespace = __NAMESPACE__ . '\\Rules';
        $class = sprintf("%s\%s", $namespace, ucfirst($name));
        if (!class_exists($class)) {
            throw new RuntimeException(sprintf('Rule not found: (%s).', $name));
        }

        $rule = new $class(...$arguments);
        if ($rule instanceof Rule) {
            return $this->add($rule);
        }

        return $this;
    }
}
