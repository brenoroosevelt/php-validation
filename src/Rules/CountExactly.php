<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\Contracts\Prioritable;
use BrenoRoosevelt\Validation\StopSign;
use BrenoRoosevelt\Validation\Translation\Translator;

#[Attribute(Attribute::TARGET_PROPERTY)]
class CountExactly extends AbstractRule
{
    const MESSAGE = 'Expected count is: %s';

    public function __construct(
        private int $size,
        ?string $message = null,
        int $stopOnFailure = StopSign::DONT_STOP,
        int $priority = Prioritable::LOWEST_PRIORITY
    ) {
        parent::__construct($message, $stopOnFailure, $priority);
    }

    public function isValid($input, array $context = []): bool
    {
        if (is_countable($input)) {
            return count($input) === $this->size;
        }

        if (is_iterable($input)) {
            $count = 0;
            foreach ($input as $v) {
                $count++;
            }

            return $count === $this->size;
        }

        return false;
    }

    public function translatedMessage(): ?string
    {
        return Translator::translate(self::MESSAGE, $this->size);
    }
}
