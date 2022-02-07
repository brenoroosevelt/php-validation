<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Cnpj extends Document
{
    public function __construct(bool $mask = true, ?string $message = 'CNPJ inválido')
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
        return '/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/';
    }

    public function unmaskedLength(): int
    {
        return 14;
    }
}
