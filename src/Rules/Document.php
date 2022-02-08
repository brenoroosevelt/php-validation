<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use BrenoRoosevelt\Validation\AbstractRule;
use Throwable;

abstract class Document extends AbstractRule
{
    public function __construct(private bool $mask = true, ?string $message = 'Invalid document')
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
        return $input;
    }

    public function validateNumbersWithCorrectLength(string $unmaskedInput): bool
    {
        $numericWithSize = '/^\d{' . $this->unmaskedLength() . '}$/';
        return preg_match($numericWithSize, $unmaskedInput) === 1;
    }

    abstract public function isValidDocument(string $input): bool;

    abstract public function maskPattern(): string;

    abstract public function unmaskedLength(): int;
}
