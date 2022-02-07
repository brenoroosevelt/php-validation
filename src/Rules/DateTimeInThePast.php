<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DateTimeInThePast extends DateTimeLessThan
{
    public function __construct(?string $message = 'The date/time should be in the past')
    {
        parent::__construct('now', $message);
    }
}
