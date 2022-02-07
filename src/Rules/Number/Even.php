<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Number;

use Attribute;
use BrenoRoosevelt\Validation\Rules\Comparison\Equal;
use BrenoRoosevelt\Validation\Rules\Rule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Even extends Rule
{
    public function __construct(?string $message = 'The number should be even')
    {
        parent::__construct(fn($input) => $input % 2 === 0, $message);
    }
}
