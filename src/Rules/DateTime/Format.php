<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\DateTime;

use Attribute;
use BrenoRoosevelt\Validation\Rules\AbstractValidation;
use DateTime;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Format extends AbstractValidation
{
    const MESSAGE = 'Invalid date/time format, use %s';

    public function __construct(private string $format, ?string $message = null)
    {
        $this->message = $message ?? sprintf(self::MESSAGE, $this->format);
        parent::__construct($message);
    }

    protected function evaluate($input, array $context = []): bool
    {
        try {
            $stringInput = (string) $input;
            $d = DateTime::createFromFormat($this->format, $stringInput);
            return $d && $d->format($this->format) === $stringInput;
        } catch (Throwable) {
            return false;
        }
    }
}
