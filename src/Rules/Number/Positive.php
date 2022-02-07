<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Number;

use Attribute;
use BrenoRoosevelt\Validation\Rules\Comparison\GreaterThan;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Positive extends GreaterThan
{
    public function __construct(?string $message = null)
    {
        parent::__construct(0, $message);
    }
}
