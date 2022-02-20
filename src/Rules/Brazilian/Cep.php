<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Cep extends AbstractRule
{
    const MESSAGE = 'Cep inválido';

    const MASK = '/^[0-9]{5}\-[0-9]{3}$/';
    const UNMASK = '/^[0-9]{8}$/';

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
        try {
            $pattern = $this->mask ? Cep::MASK : Cep::UNMASK;
            return preg_match($pattern, (string) $input) === 1;
        } catch (Throwable) {
            return false;
        }
    }
}
