<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Translation;

final class Translator
{
    private static TranslatorInterface $translator;

    public static function setDefault(TranslatorInterface|callable $translator, bool $compose = true): void
    {
        if ($translator instanceof TranslatorInterface) {
            self::$translator = $translator;
        } else {
            self::$translator = new class($translator) implements TranslatorInterface {
                private $callback;

                public function __construct(callable $callback)
                {
                    $this->callback = $callback;
                }

                public function translate(string $message, ...$args): ?string
                {
                    return call_user_func_array($this->callback, [$message, ...$args]);
                }
            };
        }

        if ($compose) {
            self::$translator = new CompositeTranslator(self::$translator, self::createDefault());
        }
    }

    public static function getDefault(): TranslatorInterface
    {
        return self::$translator ?? self::$translator = self::createDefault();
    }

    private static function createDefault(): TranslatorInterface
    {
        return new class implements TranslatorInterface {
            public function translate(string $message, ...$args): ?string
            {
                return sprintf($message, ...$args);
            }
        };
    }

    public static function translate(string $message, ...$args): string
    {
        return self::getDefault()->translate($message, ...$args) ?? $message;
    }

    private function __construct()
    {
    }
}
