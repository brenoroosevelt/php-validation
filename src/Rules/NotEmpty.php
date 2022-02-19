<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\StopSign;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotEmpty extends AbstractRule
{
    const MESSAGE = 'This value cannot be left empty';

    public function __construct(
        ?string $message = self::MESSAGE,
        int $stopOnFailure = StopSign::DONT_STOP
    ) {
        parent::__construct($message, $stopOnFailure);
    }

    public function isValid($input, array $context = []): bool
    {
        return !(new IsEmpty)->isValid($input, $context);
    }
}
