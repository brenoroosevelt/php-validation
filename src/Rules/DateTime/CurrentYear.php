<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\DateTime;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use DateTimeImmutable;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class CurrentYear extends AbstractRule
{
    const MESSAGE = 'The date/time should be in the current year';
    const CURRENT_YEAR = 'Y';

    public function isValid($input, array $context = []): bool
    {
        try {
            $now = new DateTimeImmutable();
            $datetime = new DateTimeImmutable($input);
            $format = self::CURRENT_YEAR;
            return $datetime->format($format) === $now->format($format);
        } catch (Throwable) {
            return false;
        }
    }
}
