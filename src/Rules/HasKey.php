<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use ArrayAccess;
use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\StopSign;
use BrenoRoosevelt\Validation\Translation\Translator;

#[Attribute(Attribute::TARGET_PROPERTY)]
class HasKey extends AbstractRule
{
    const MESSAGE = 'Key not found: %s';

    public function __construct(
        private string $key,
        ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP
    ) {
        parent::__construct($message, $stopOnFailure);
    }

    public function isValid($input, array $context = []): bool
    {
        if (is_array($input)) {
            return array_key_exists($this->key, $input);
        }

        if ($input instanceof ArrayAccess) {
            return $input->offsetExists($this->key);
        }

        if (is_iterable($input)) {
            foreach ($input as $k => $v) {
                if ($this->key === $k) {
                    return true;
                }
            }
        }

        return false;
    }

    public function translatedMessage(): ?string
    {
        return Translator::translate(self::MESSAGE, $this->key);
    }
}
