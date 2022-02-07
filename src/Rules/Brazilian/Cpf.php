<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;
use BrenoRoosevelt\Validation\AbstractValidation;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Cpf extends AbstractValidation
{
    const LENGTH = 11;
    const MASK = '/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/';

    public function __construct(private bool $mask = true, ?string $message = 'CPF inválido')
    {
        parent::__construct($message);
    }

    public function evaluate($input, array $context = []): bool
    {
        if ($this->mask && preg_match(Cpf::MASK, (string) $input) !== 1) {
            return false;
        }

        $numbers = preg_replace('/\D/', '', (string) $input);
        $cpf = str_pad($numbers, Cpf::LENGTH, '0', STR_PAD_LEFT);
        if (strlen($cpf) !== Cpf::LENGTH) {
            return false;
        }

        $number = substr($cpf, 0, -2);
        $digits = substr($cpf, -2);

        $digit1 = DigitoVerificador::mod11($number);
        $digit2 = DigitoVerificador::mod11($number . $digit1);

        return $digits === ($digit1 . $digit2);
    }
}
