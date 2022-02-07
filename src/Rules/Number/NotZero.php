<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Number;

use Attribute;
use BrenoRoosevelt\Validation\Rules\Comparison\NotEqual;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotZero extends NotEqual
{
    public function __construct(?string $message = null)
    {
        parent::__construct(0, $message);
    }
}
