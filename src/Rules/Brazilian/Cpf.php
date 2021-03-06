<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Cpf extends AbstractRule
{
    const MESSAGE = 'CPF inválido';

    const MASK = '/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/';
    const LENGTH = 11;

    public function __construct(
        private bool $mask = true,
        ?string $message = null,
        ?int $stopOnFailure = null,
        ?int $priority = null
    ) {
        parent::__construct($message, $stopOnFailure, $priority);
    }

    public function isValid(mixed $input, array $context = []): bool
    {
        if (!is_string($input) || !is_numeric($input)) {
            return false;
        }

        $cpf = (string) $input;
        if ($this->mask) {
            if (preg_match(Cpf::MASK, $cpf) !== 1) {
                return false;
            }

            $cpf = preg_replace('/\D/', '', $cpf);
        }

        $cpf = str_pad($cpf, Cpf::LENGTH, '0', STR_PAD_LEFT);
        if (strlen($cpf) !== Cpf::LENGTH) {
            return false;
        }

        return DigitoVerificador::checkCpfCnpjDigits($cpf);
    }
}
