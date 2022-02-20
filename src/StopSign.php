<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation;

final class StopSign
{
    const DONT_STOP = 0;
    const SAME_FIELD = 1;
    const ALL = 2;

    public static function allowed(): array
    {
        return [self::DONT_STOP, self::SAME_FIELD, self::ALL];
    }

    /** @codeCoverageIgnore */
    private function __construct()
    {
    }
}
