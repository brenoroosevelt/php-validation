<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FoneSemDDD extends AbstractRule
{
    const MASK = '/^\[0-9]{4,5}-[0-9]{4}$/';
    const UNMASK = '/^\[0-9]{8,9}$/';

    public function __construct(private bool $mask = true, ?string $message = 'Telefone inválido')
    {
        parent::__construct($message);
    }

    public function evaluate($input, array $context = []): bool
    {
        if (!is_string($input) || !is_numeric($input)) {
            return false;
        }

        $pattern = $this->mask ? self::MASK : self::UNMASK;
        return preg_match($pattern, $input) === 1;
    }
}
