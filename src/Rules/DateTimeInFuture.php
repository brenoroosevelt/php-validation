<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use DateTimeImmutable;
use DateTimeInterface;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DateTimeInFuture extends AbstractValidation
{
    private ?DateTimeInterface $now = null;

    public function __construct(?string $message = 'The date/time should be in the future')
    {
        parent::__construct($message);
    }

    public function setNow(DateTimeInterface $now): void
    {
        $this->now = $now;
    }

    public function getNow(): DateTimeInterface
    {
        return $this->now instanceof DateTimeInterface ? $this->now : new DateTimeImmutable();
    }

    protected function isValid($input, array $context = []): bool
    {
        try {
            $datetime =
                $input instanceof DateTimeInterface ?
                    $input :
                    new DateTimeImmutable($input);

            return $datetime > $this->getNow();
        } catch (Throwable) {
            return false;
        }
    }
}
