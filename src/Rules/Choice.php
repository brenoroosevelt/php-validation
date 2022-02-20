<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\Translation\Translator;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Choice extends AbstractRule
{
    const MESSAGE = 'Invalid choice, accepted values: %s';

    public function __construct(
        private array $list,
        private bool $strict = true,
        ?string $message = null,
        ?int $stopOnFailure = null,
        ?int $priority = null
    ) {
        parent::__construct($message, $stopOnFailure, $priority);
    }

    public function isValid($input, array $context = []): bool
    {
        return in_array($input, $this->list, $this->strict);
    }

    public function translatedMessage(): ?string
    {
        return Translator::translate(self::MESSAGE, trim(implode(', ', $this->list)));
    }
}
