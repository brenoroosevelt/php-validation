<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\DateTime;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use DateTimeImmutable;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class CurrentDay extends AbstractRule
{
    const TODAY_FORMAT = 'Y-m-d';

    public function __construct(?string $message = 'The date/time should be today')
    {
        parent::__construct($message);
    }

    public function isValid($input, array $context = []): bool
    {
        try {
            $now = new DateTimeImmutable();
            $datetime = new DateTimeImmutable($input);

            return $datetime->format(self::TODAY_FORMAT) === $now->format(self::TODAY_FORMAT);
        } catch (Throwable) {
            return false;
        }
    }
}
