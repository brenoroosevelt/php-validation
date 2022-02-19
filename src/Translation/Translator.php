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
            self::$default = new CallableTranslator($translator);
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
        return new NaiveTranslator;
    }

    public static function translate(string $message, ...$args): string
    {
        return self::getDefault()->translate($message, ...$args) ?? $message;
    }

    private function __construct()
    {
    }
}
