<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\DateTime;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\Translation\Translator;
use DateTime;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DateTimeFormat extends AbstractRule
{
    const MESSAGE = 'Invalid date/time format, use %s';

    public function __construct(
        private string $format,
        ?string $message = null,
        ?int $stopOnFailure = null,
        ?int $priority = null
    ) {
        parent::__construct($message, $stopOnFailure, $priority);
    }

    public function isValid($input, array $context = []): bool
    {
        try {
            $stringInput = (string) $input;
            $d = DateTime::createFromFormat($this->format, $stringInput);
            return $d && $d->format($this->format) === $stringInput;
        } catch (Throwable) {
            return false;
        }
    }

    public function translatedMessage(): ?string
    {
        return Translator::translate(self::MESSAGE, $this->format);
    }
}
