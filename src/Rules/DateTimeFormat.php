<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use DateTime;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DateTimeFormat extends AbstractValidation
{
    const MESSAGE = 'Formato de data e/ou hora inválido, use %s';

    public function __construct(private string $format, ?string $message = null)
    {
        $this->message = $message ?? sprintf(self::MESSAGE, $this->format);
        parent::__construct($message);
    }

    protected function isValid($input, array $context = []): bool
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
