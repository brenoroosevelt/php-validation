<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Type;

use Attribute;
use BrenoRoosevelt\Validation\StopSign;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsInstanceOf extends TypeRule
{
    public function __construct(
        private string $class,
        ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP
    ) {
        parent::__construct($message, $stopOnFailure);
    }

    public function isValid($input, array $context = []): bool
    {
        return $input instanceof $this->class;
    }

    protected function typeName(): string
    {
        return $this->class;
    }
}
