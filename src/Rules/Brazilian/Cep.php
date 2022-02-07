<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;
use BrenoRoosevelt\Validation\AbstractValidation;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Cep extends AbstractValidation
{
    public function __construct(?string $message = 'Cep inválido')
    {
        parent::__construct($message);
    }

    public function evaluate($input, array $context = []): bool
    {
        //TODO: validate
        return false;
    }
}
