<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use BrenoRoosevelt\Validation\AbstractValidation;
use InvalidArgumentException;
use Throwable;

class DigitoVerificador extends AbstractValidation
{
    const MOD11 = 0;
    const MOD10 = 1;

    public function __construct(private int $algorithm = self::MOD11, ?string $message = 'Dígito verificador inválido')
    {
        parent::__construct($message);
    }

    public function evaluate($input, array $context = []): bool
    {
        try {
            $stringInput = (string) $input;
        } catch (Throwable $exception) {
            return false;
        }

        if (preg_match('/^\d$/', $stringInput) !== 1) {
            return false;
        }

        $number = substr($stringInput, 0, -1);
        $digit = (int) substr($stringInput, -1);
        return
            $digit === match ($this->algorithm) {
                self::MOD11 => self::mod11($number),
                self::MOD10 => self::mod10($number),
                default => throw new InvalidArgumentException('Algoritmo de cálculo de dígito inválido')
            };
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

    public static function checkCpfCnpjDigits(string $document): bool
    {
        $document = preg_replace('/\D/', '', $document);
        $number = substr($document, 0, -2);
        $digits = substr($document, -2);

        $digit1 = DigitoVerificador::mod11($number);
        $digit2 = DigitoVerificador::mod11($number . $digit1);

        return $digits === ($digit1 . $digit2);
    }
}
