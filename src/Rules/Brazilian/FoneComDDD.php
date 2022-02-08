<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FoneComDDD extends AbstractRule
{
    const WITH_MASK = '/^\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}$/';
    const NO_MASK = '/^\[0-9]{10,11}$/';

    public function __construct(private bool $mask = true, ?string $message = 'Telefone inválido')
    {
        parent::__construct($message);
    }

    public function evaluate($input, array $context = []): bool
    {
        try {
            $fone = (string) $input;
        } catch (Throwable) {
            return false;
        }

        $pattern = $this->mask ? self::WITH_MASK : self::NO_MASK;
        return preg_match($pattern, $fone) === 1;
    }
}
