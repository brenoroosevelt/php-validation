<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules\DateTime;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use DateTimeImmutable;
use DateTimeInterface;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class LessThan extends AbstractRule
{
    public function __construct(private string $datetime = 'now', ?string $message = null)
    {
        parent::__construct($message ?? sprintf('The date/time should be less than %s', $this->datetime));
    }

    private function datetime(): DateTimeInterface
    {
        return new DateTimeImmutable($this->datetime);
    }

    public function isValid($input, array $context = []): bool
    {
        try {
            $datetime =
                $input instanceof DateTimeInterface ?
                    $input :
                    new DateTimeImmutable($input);

            return $datetime < $this->datetime();
        } catch (Throwable) {
            return false;
        }
    }
}
