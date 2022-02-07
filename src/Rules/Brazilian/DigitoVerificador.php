<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;
use BrenoRoosevelt\Validation\AbstractValidation;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DigitoVerificador extends AbstractValidation
{
    public function __construct(?string $message = 'Dígito verificador inválido')
    {
        parent::__construct($message);
    }

    public function evaluate($input, array $context = []): bool
    {
        $numbers = preg_replace('/\D/', '', (string) $input);
        $number = substr($numbers, 0, -1);
        $digit = (int) substr($numbers, -1);
        return self::mod11($number) === $digit;
    }

    public static function mod11($input): int
    {
        $numbers = array_reverse(str_split((string) $input));
        $factor = [2, 3, 4, 5, 6, 7, 8, 9];
        $size = count($factor);
        $i = $sum = 0;
        foreach ($numbers as $number) {
            $sum += $number * $factor[$i++ % $size];
        }

        return 11 - (($sum * 10 ) % 11);
    }

    public static function mod10($input): int
    {
        $numbers = array_reverse(str_split((string) $input));
        $factor = [2, 1];
        $size = count($factor);
        $i = $sum = 0;
        foreach ($numbers as $number) {
            $num = $number * $factor[$i++ % $size];
            $sum += array_sum(str_split((string) $num));
        }

        return 10 - ($sum % 10);
    }
}
