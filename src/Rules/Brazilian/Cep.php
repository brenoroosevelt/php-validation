<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Cep extends Document
{
    public function __construct(bool $mask = true, ?string $message = 'CEP inválido')
    {
        parent::__construct($mask, $message);
    }

    protected function isValidDocument(string $input): bool
    {
        return $this->validateNumbersWithCorrectLength($input);
    }

    protected function adjustZeroPadding(string $input): string
    {
        return $input;
    }

    protected function maskPattern(): string
    {
        return '/^[0-9]{5}\-[0-9]{3}$/';
    }

    protected function unmaskedLength(): int
    {
        return 9;
    }
}
