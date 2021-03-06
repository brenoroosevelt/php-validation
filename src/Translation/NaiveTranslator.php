<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Translation;

class NaiveTranslator implements TranslatorInterface
{
    public function translate(string $message, ...$args): ?string
    {
        return sprintf($message, ...$args);
    }
}
