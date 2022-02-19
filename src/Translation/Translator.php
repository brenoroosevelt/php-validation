<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Translation;

final class Translator
{
    private static TranslatorInterface $default;

    public static function setDefault(TranslatorInterface|callable $translator, bool $compose = true): void
    {
        if ($translator instanceof TranslatorInterface) {
            self::$default = $translator;
        } else {
            // inline callback translator
            self::$default = new class($translator) implements TranslatorInterface {
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
            self::$default = new CompositeTranslator(self::$default, self::createDefault());
        }
    }

    public static function getDefault(): TranslatorInterface
    {
        return self::$default ?? self::$default = self::createDefault();
    }

    private static function createDefault(): TranslatorInterface
    {
        // inline default translator
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
