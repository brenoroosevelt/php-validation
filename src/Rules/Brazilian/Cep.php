<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;
use BrenoRoosevelt\Validation\Rules\Document;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Cep extends Document
{
    public function __construct(bool $mask = true, ?string $message = 'CEP inválido')
    {
        parent::__construct($mask, $message);
    }

    public function isValidDocument(string $input): bool
    {
        return $this->validateNumbersWithCorrectLength($input);
    }

    public function maskPattern(): string
    {
        return '/^[0-9]{5}\-[0-9]{3}$/';
    }

    public function unmaskedLength(): int
    {
        return 9;
    }
}
