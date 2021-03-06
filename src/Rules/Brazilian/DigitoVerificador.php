<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use BrenoRoosevelt\Validation\AbstractRule;
use InvalidArgumentException;
use Throwable;

class DigitoVerificador extends AbstractRule
{
    const MESSAGE = 'Dígito verificador inválido';

    const MOD11 = 0;
    const MOD10 = 1;

    public function __construct(
        private int $algorithm = self::MOD11,
        ?string $message = null,
        ?int $stopOnFailure = null,
        ?int $priority = null
    ) {
        parent::__construct($message, $stopOnFailure, $priority);
    }

    public function isValid($input, array $context = []): bool
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

    public static function mod11($input, $modReturn = []): int
    {
        $numbers = array_reverse(str_split((string) $input));
        $factor = [2, 3, 4, 5, 6, 7, 8, 9];
        $size = count($factor);
        $i = $sum = 0;
        foreach ($numbers as $number) {
            $sum += $number * $factor[$i++ % $size];
        }

        $mod11 = ($sum * 10 ) % 11;
        return $modReturn[$mod11] ?? 11 - $mod11;
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

        $modReturn = [0 => 0, 1 => 0];
        $digit1 = DigitoVerificador::mod11($number, $modReturn);
        $digit2 = DigitoVerificador::mod11($number . $digit1, $modReturn);

        return $digits === ($digit1 . $digit2);
    }
}
