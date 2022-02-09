<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\DateTime;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use DateTimeImmutable;
use DateTimeInterface;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class LessThanAnother extends AbstractRule
{
    public function __construct(private string $other, ?string $message = null)
    {
        parent::__construct($message ?? sprintf('The date/time should be less than %s', $this->other));
    }

    public function isValid($input, array $context = []): bool
    {
        try {
            $datetime =
                $input instanceof DateTimeInterface ?
                    $input :
                    new DateTimeImmutable($input);

            return array_key_exists($this->other, $context)
                && $datetime < (new DateTimeImmutable($context[$this->other]));
        } catch (Throwable) {
            return false;
        }
    }
}
