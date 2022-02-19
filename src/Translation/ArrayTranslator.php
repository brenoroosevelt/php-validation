<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Translation;

class ArrayTranslator implements TranslatorInterface
{
    public function __construct(protected array $translations = [])
    {
    }

    public function translate(string $message, string ...$args): ?string
    {
        return $this->translations[$message] ?? null;
    }
}
