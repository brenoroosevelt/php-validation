<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\Translation\Translator;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Regex extends AbstractRule
{
    const MESSAGE = 'Value does not match pattern: %s';

    public function __construct(
        private string $pattern,
        ?string $message = null,
        ?int $stopOnFailure = null,
        ?int $priority = null
    ) {
        parent::__construct($message, $stopOnFailure, $priority);
    }

    public function isValid($input, array $context = []): bool
    {
        try {
            $subject = (string) $input;
            return preg_match($this->pattern, $subject) === 1;
        } catch (Throwable) {
            return false;
        }
    }

    public function translatedMessage(): ?string
    {
        return Translator::translate(self::MESSAGE, $this->pattern);
    }
}
