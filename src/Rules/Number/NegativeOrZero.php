<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Number;

use Attribute;
use BrenoRoosevelt\Validation\Rules\Comparison\LessThanOrEqual;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NegativeOrZero extends LessThanOrEqual
{
    public function __construct(?string $message = null)
    {
        parent::__construct(0, $message);
    }
}
