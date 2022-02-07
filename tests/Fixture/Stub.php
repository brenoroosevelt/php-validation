<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests\Fixture;

use BrenoRoosevelt\Validation\Rules\IsInteger;
use BrenoRoosevelt\Validation\Rules\IsNumeric;

class Stub
{
    #[IsInteger]
    #[IsNumeric]
    private int $int;
}
