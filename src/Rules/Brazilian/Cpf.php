<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Cpf extends Document
{
    public function __construct(bool $mask = true, ?string $message = 'CPF inválido')
    {
        parent::__construct($mask, $message);
    }

    public function isValidDocument(string $input): bool
    {
        if (!$this->validateNumbersWithCorrectLength($input)) {
            return false;
        }

        return $this->validateCpfCnpjDigits($input);
    }

    public function maskPattern(): string
    {
        return '/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/';
    }

    public function unmaskedLength(): int
    {
        return 11;
    }
}
