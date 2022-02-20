<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Cnpj extends AbstractRule
{
    const MESSAGE = 'CNPJ inválido';

    const MASK = '/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/';
    const LENGTH = 14;

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

        $cnpj = (string) $input;
        if ($this->mask) {
            if (preg_match(Cnpj::MASK, $cnpj) !== 1) {
                return false;
            }

            $cnpj = preg_replace('/\D/', '', $cnpj);
        }

        $cnpj = str_pad($cnpj, Cnpj::LENGTH, '0', STR_PAD_LEFT);
        if (strlen($cnpj) !== Cnpj::LENGTH) {
            return false;
        }

        return DigitoVerificador::checkCpfCnpjDigits($cnpj);
    }
}
