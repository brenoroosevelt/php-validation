<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Validation\Rules;

use Attribute;
use BrenoRoosevelt\Validation\AbstractRule;
use BrenoRoosevelt\Validation\StopSign;

#[Attribute(Attribute::TARGET_PROPERTY|Attribute::TARGET_METHOD)]
class NotNull extends AbstractRule
{
    const MESSAGE = 'This value cannot be null';

    public function __construct(
        ?string $message = self::MESSAGE,
        int $stopOnFailure = StopSign::DONT_STOP
    ) {
        parent::__construct($message, $stopOnFailure);
    }

    public function isValid($input, array $context = []): bool
    {
        return !is_null($input);
    }
}
