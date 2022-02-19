<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Translation;

use Closure;

class CallableTranslator implements TranslatorInterface
{
    private Closure $translator;

    public function __construct(callable $translator)
    {
        $this->translator = Closure::fromCallable($translator);
    }

    public function translate(string $message, string ...$args): ?string
    {
        return ($this->translator)($message, ...$args);
    }
}
