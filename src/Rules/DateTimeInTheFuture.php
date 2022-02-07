<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use DateTimeInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DateTimeInTheFuture extends DateTimeGreaterThan
{
    public function __construct(?string $message = 'The date/time should be in the future')
    {
        parent::__construct('now', $message);
    }
}
