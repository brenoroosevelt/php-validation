<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Number;

use Attribute;
use BrenoRoosevelt\Validation\Rules\Comparison\Equal;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Zero extends Equal
{
    public function __construct(?string $message = null)
    {
        parent::__construct(0, $message);
    }
}
