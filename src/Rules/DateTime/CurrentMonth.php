<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\DateTime;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use DateTimeImmutable;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class CurrentMonth extends AbstractRule
{
    const CURRENT_MONTH = 'm';
    const CURRENT_MONTH_SAME_YEAR = 'Y-m';
    const MESSAGE = 'The date/time should be in the current month%s';

    public function __construct(private bool $sameYear = true, ?string $message = null)
    {
        $message = $message ?? sprintf(self::MESSAGE, $this->sameYear ? ' (and same year)' : '');
        parent::__construct($message);
    }

    protected function evaluate($input, array $context = []): bool
    {
        try {
            $now = new DateTimeImmutable();
            $datetime = new DateTimeImmutable($input);
            $format = $this->sameYear ? self::CURRENT_MONTH_SAME_YEAR : self::CURRENT_MONTH;
            return $datetime->format($format) === $now->format($format);
        } catch (Throwable) {
            return false;
        }
    }
}
