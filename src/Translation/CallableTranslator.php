<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Translation;

class CallableTranslator implements TranslatorInterface
{
    /** @var callable */
    private $callback;

    public function __construct(callable $translator)
    {
        $this->callback = $translator;
    }

    public function translate(string $message, ...$args): ?string
    {
        return call_user_func_array($this->callback, [$message, ...$args]);
    }
}
