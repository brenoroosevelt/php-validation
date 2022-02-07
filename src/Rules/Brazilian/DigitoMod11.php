<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DigitoMod11 extends DigitoVerificador
{
    protected function getDigit($number): int
    {
        return DigitoVerificador::mod11($number);
    }
}
