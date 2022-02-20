<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FoneComDDD extends AbstractRule
{
    const MESSAGE = 'Telefone inválido';

    const MASK = '/^\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}$/';
    const UNMASK = '/^\[0-9]{10,11}$/';

    public function __construct(
        private bool $mask = true,
        ?string $message = null,
        ?int $stopOnFailure = null,
        ?int $priority = null
    ) {
        parent::__construct($message, $stopOnFailure, $priority);
    }

    public function isValid($input, array $context = []): bool
    {
        try {
            $pattern = $this->mask ? self::MASK : self::UNMASK;
            return preg_match($pattern, (string) $input) === 1;
        } catch (Throwable) {
            return false;
        }
    }
}
