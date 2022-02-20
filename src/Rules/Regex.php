<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\Contracts\Prioritable;
use BrenoRoosevelt\Validation\StopSign;
use BrenoRoosevelt\Validation\Translation\Translator;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Regex extends AbstractRule
{
    const MESSAGE = 'Value does not match pattern: %s';

    public function __construct(
        private string $pattern,
        ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP,
        int $priority = Prioritable::LOWEST_PRIORITY
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
