<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DigitoMod10 extends DigitoVerificador
{
    protected function getDigit($number): int
    {
        return DigitoVerificador::mod10($number);
    }
}
