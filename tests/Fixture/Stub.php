<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests\Fixture;

use BrenoRoosevelt\Validation\Rules\IsInteger;
use BrenoRoosevelt\Validation\Rules\IsNumeric;
use BrenoRoosevelt\Validation\ValidationSet;
use BrenoRoosevelt\Validation\Validator;

class Stub
{
    #[IsInteger]
    #[IsNumeric]
    private int $int;

    public function x() {

    }
}
