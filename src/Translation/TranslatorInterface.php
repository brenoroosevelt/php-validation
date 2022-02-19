<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Translation;

interface TranslatorInterface
{
    public function translate(string $message, string ...$args): ?string;
}
