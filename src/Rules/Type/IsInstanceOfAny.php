<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Type;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\StopSign;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsInstanceOfAny extends AbstractRule
{
    const MESSAGE = 'The value must be of one of the types: %s';

    public function __construct(
        private array $classes,
        ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP,
        int $priority = 0
    ) {
        $message = $message ?? sprintf(self::MESSAGE, trim(implode(', ', $this->classes)));
        parent::__construct($message, $stopOnFailure, $priority);
    }

    public function isValid($input, array $context = []): bool
    {
        foreach ($this->classes as $class) {
            if ($input instanceof $class) {
                return true;
            }
        }

        return false;
    }
}
