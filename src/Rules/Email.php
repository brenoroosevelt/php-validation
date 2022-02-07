<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Email extends AbstractValidation
{
    const MESSAGE = 'Invalid e-mail';

    public function __construct(?string $message = self::MESSAGE)
    {
        parent::__construct($message);
    }

    public function isValid($input, array $context = []): bool
    {
        return
            is_string($input) &&
            filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
    }
}
