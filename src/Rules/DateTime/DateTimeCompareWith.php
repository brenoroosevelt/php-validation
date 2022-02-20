<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\DateTime;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\Comparator;
use BrenoRoosevelt\Validation\Translation\Translator;
use DateTimeImmutable;
use DateTimeInterface;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DateTimeCompareWith extends AbstractRule
{
    const MESSAGE = 'The date/time should be %s `%s`';

    use Comparator;

    public function __construct(
        private string $operator,
        private string $other,
        ?string $message = null,
        ?int $stopOnFailure = null,
        ?int $priority = null
    ) {
        parent::__construct($message, $stopOnFailure, $priority);
    }

    public function isValid($input, array $context = []): bool
    {
        try {
            $other = fn() => new DateTimeImmutable($context[$this->other]);
            $datetime =
                $input instanceof DateTimeInterface ?
                    $input :
                    new DateTimeImmutable($input);

            return array_key_exists($this->other, $context)
                && $this->compare($datetime, $this->operator, $other());
        } catch (Throwable) {
            return false;
        }
    }

    public function translatedMessage(): ?string
    {
        $translatedOperator = Translator::translate($this->operator);
        return Translator::translate(self::MESSAGE, $translatedOperator, $this->other);
    }
}
