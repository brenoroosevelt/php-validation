<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Type;

use Attribute;
use BrenoRoosevelt\Validation\StopSign;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsType extends TypeRule
{
    public function __construct(
        private string $type,
        ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP
    ) {
        parent::__construct($message, $stopOnFailure);
    }

    public function isValid($input, array $context = []): bool
    {
        return gettype($input) === $this->type;
    }

    protected function typeName(): string
    {
        return $this->type;
    }
}
