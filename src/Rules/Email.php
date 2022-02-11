<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\StopSign;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Email extends AbstractRule
{
    const MESSAGE = 'Invalid e-mail';

    public function __construct(?string $message = self::MESSAGE, int $stopOnFailure = StopSign::DONT_STOP)
    {
        parent::__construct($message, $stopOnFailure);
    }

    public function isValid($input, array $context = []): bool
    {
        return
            is_string($input) &&
            filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
    }
}
