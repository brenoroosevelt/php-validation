<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use DateTimeImmutable;
use DateTimeInterface;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DateTimeInPast extends AbstractValidation
{
    private DateTimeInterface $now;

    public function __construct(?string $message = 'The date/time should be in the past')
    {
        $this->setNow(new DateTimeImmutable());
        parent::__construct($message);
    }

    public function setNow(DateTimeInterface $now): void
    {
        $this->now = $now;
    }

    protected function isValid($input, array $context = []): bool
    {
        try {
            $datetime =
                $input instanceof DateTimeInterface ?
                    $input :
                    new DateTimeImmutable($input);

            return $datetime < $this->now;
        } catch (Throwable) {
            return false;
        }
    }
}
