<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Number;

use Attribute;
use BrenoRoosevelt\Validation\Rules\Comparison\Equal;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Odd extends Equal
{
    public function __construct(?string $message = 'The number should be odd')
    {
        parent::__construct(fn($input) => $input % 2 !== 0, $message);
    }
}
