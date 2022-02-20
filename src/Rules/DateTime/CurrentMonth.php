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
    const MESSAGE = 'The date/time should be in the current month';
    const CURRENT_MONTH = 'm';
    const CURRENT_MONTH_SAME_YEAR = 'Y-m';

    public function __construct(
        private bool $sameYear = true,
        ?string $message = null,
        ?int $stopOnFailure = null,
        ?int $priority = null
    ) {
        parent::__construct($message, $stopOnFailure, $priority);
    }

    public function isValid($input, array $context = []): bool
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
