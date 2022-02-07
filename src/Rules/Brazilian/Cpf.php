<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;
use BrenoRoosevelt\Validation\AbstractValidation;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Cpf extends AbstractValidation
{
    public function __construct(?string $message = 'CPF inválido')
    {
        parent::__construct($message);
    }

    public function evaluate($input, array $context = []): bool
    {
        //TODO: validate
        return false;
    }
}
