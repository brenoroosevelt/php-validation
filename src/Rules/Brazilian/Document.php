<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\Brazilian;

use Attribute;
use BrenoRoosevelt\Validation\AbstractValidation;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
abstract class Document extends AbstractValidation
{
    public function __construct(private bool $mask = true, ?string $message = 'Documento inválido')
    {
        parent::__construct($message);
    }

    public function evaluate($input, array $context = []): bool
    {
        try {
            $document = (string) $input;
        } catch (Throwable) {
            return false;
        }

        if ($this->mask) {
            if (!$this->isValidMask($document)) {
                return false;
            }

            $document = $this->unmaskNumber($document);
        }

        $document = $this->adjustZeroPadding($document);
        return $this->isValidDocument($document);
    }

    public function isValidMask(string $input): bool
    {
        return preg_match($this->maskPattern(), $input) === 1;
    }

    public function unmaskNumber(string $input): string
    {
        return preg_replace('/\D/', '', $input);
    }

    public function adjustZeroPadding(string $input): string
    {
        return str_pad($input, $this->unmaskedLength(), '0', STR_PAD_LEFT);
    }

    public function validateNumbersWithCorrectLength(string $unmaskedInput): bool
    {
        $numericWithSize = '/^\d{' . $this->unmaskedLength() . '}$/';
        return preg_match($numericWithSize, $unmaskedInput) === 1;
    }

    public function validateCpfCnpjDigits(string $unmaskedDocument): bool
    {
        $number = substr($unmaskedDocument, 0, -2);
        $digits = substr($unmaskedDocument, -2);

        $digit1 = DigitoVerificador::mod11($number);
        $digit2 = DigitoVerificador::mod11($number . $digit1);

        return $digits === ($digit1 . $digit2);
    }

    abstract public function isValidDocument(string $input): bool;

    abstract public function maskPattern(): string;

    abstract public function unmaskedLength(): int;
}
