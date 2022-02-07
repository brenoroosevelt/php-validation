<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use DateTimeImmutable;
use DateTimeInterface;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DateTimeLessThan extends AbstractValidation
{
    public function __construct(private string $datetime = 'now', ?string $message = null)
    {
        parent::__construct($message ?? sprintf('The date/time should be less than %s', $this->datetime));
    }

    private function datetime(): DateTimeInterface
    {
        return new DateTimeImmutable($this->datetime);
    }

    protected function isValid($input, array $context = []): bool
    {
        try {
            $datetime =
                $input instanceof DateTimeInterface ?
                    $input :
                    new DateTimeImmutable($input);

            return $datetime < $this->datetime();
        } catch (Throwable) {
            return false;
        }
    }
}
