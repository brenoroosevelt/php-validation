<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Cep extends AbstractRule
{
    const MASK = '/^[0-9]{5}\-[0-9]{3}$/';
    const UNMASK = '/^[0-9]{8}$/';

    public function __construct(private bool $mask = true, ?string $message = 'CEP inválido')
    {
        parent::__construct( $message);
    }

    protected function evaluate(mixed $input, array $context = []): bool
    {
        if (!is_string($input) || !is_numeric($input)) {
            return false;
        }

        $pattern = $this->mask ? Cep::MASK : Cep::UNMASK;
        return preg_match($pattern, (string) $input) === 1;
    }
}
