<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class PregMatch extends AbstractRule
{
    public function __construct(private string $pattern, ?string $message = null)
    {
        parent::__construct($message ?? sprintf('Value does not match pattern: %s', $this->pattern));
    }

    public function isValid($input, array $context = []): bool
    {
        try {
            $subject = (string) $input;
            return preg_match($this->pattern, $subject) === 1;
        } catch (Throwable $exception) {
            return false;
        }
    }
}
