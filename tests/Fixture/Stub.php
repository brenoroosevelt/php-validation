<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Tests\Fixture;

use BrenoRoosevelt\Validation\Rules;

class Stub
{
    #[Rules\AllowEmpty]
    #[Rules\Type\IsInteger(message: 'Deve ser um inteiro')]
    #[Rules\Type\IsNumeric]
    #[Rules\Brazilian\Cpf]
    private ?int $int;

    #[Rules\DateTime\Format(DATE_ISO8601)]
    #[Rules\Generic([self::class, 'x'])]
    private string $date = '';
}
