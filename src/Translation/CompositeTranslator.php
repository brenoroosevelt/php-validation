<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Translation;

class CompositeTranslator implements TranslatorInterface
{
    /** @var TranslatorInterface[] */
    private array $translators;

    public function __construct(TranslatorInterface ...$translators)
    {
        $this->translators = $translators;
    }

    public function translate(string $message, ...$args): ?string
    {
        foreach ($this->translators as $translator) {
            $translated = $translator->translate($message, ...$args);
            if (null !== $translated) {
                return $translated;
            }
        }

        return null;
    }
}
