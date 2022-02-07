<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Type;

use Attribute;
use BrenoRoosevelt\Validation\Rules\AbstractValidation;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsInstanceOf extends AbstractValidation
{
    public function __construct(private string $class, ?string $message = null)
    {
        parent::__construct($message);
    }

    protected function isValid($input, array $context = []): bool
    {
        return $input instanceof $this->class;
    }
}
