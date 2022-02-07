<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests\Fixture;

use BrenoRoosevelt\Validation\Rules;

class Stub
{
    #[Rules\Type\IsInteger]
    #[Rules\Type\IsNumeric]
    private int $int;

    #[Rules\DateTime\Format(DATE_ISO8601)]
    private string $date = '';

    public function x() {

    }
}
