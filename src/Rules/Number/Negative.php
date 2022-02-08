<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Number;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\Rules\Comparison\LessThan;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Negative extends LessThan
{
    public function __construct(?string $message = null)
    {
        parent::__construct(0, $message);
    }
}
